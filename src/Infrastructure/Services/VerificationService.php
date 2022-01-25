<?php

namespace App\Infrastructure\Services;

use App\Domain\Dispatcher;
use App\Domain\Verification\Entity\Verification;
use App\Domain\Verification\Interfaces\VerificationServiceInterface;
use App\Domain\Verification\Listeners\VerificationConfirmedListener;
use App\Domain\Verification\Listeners\VerificationCreatedListener;
use App\Domain\Verification\ObjectValue\Subject;
use App\Domain\Verification\ObjectValue\UserInfo;
use App\Infrastructure\Dto\ConfirmDto;
use App\Infrastructure\Dto\UserInfoDto;
use App\Infrastructure\Dto\VerificationDto;
use App\Infrastructure\Exception\DublicateExeption;
use App\Infrastructure\Exception\ExpiredException;
use App\Infrastructure\Exception\NoPermissionException;
use App\Infrastructure\Exception\ValidateException;
use App\Infrastructure\Repository\VerificationRepository;
use Doctrine\DBAL\Types\GuidType;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

class VerificationService implements VerificationServiceInterface
{
    /**
     * @var VerificationRepository
     */
    private $verificationRepository;

    /**
     * @var ContainerBagInterface
     */
    private $params;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(
        VerificationRepository $verificationRepository,
        ContainerBagInterface $params,
        RequestStack $requestStack,
        Dispatcher $dispatcher
    ) {
        $this->verificationRepository = $verificationRepository;
        $this->params = $params;
        $this->request = $requestStack->getCurrentRequest();
        $this->dispatcher = $dispatcher;
    }

    public function create($data): Verification
    {
        $data = VerificationDto::fromArray($data)->getSubject();
        $user_info = UserInfoDto::fromRequest($this->request);
        $user_info = new UserInfo($user_info->getIp(), $user_info->getUserAgent());
        $subject = new Subject($data->type, $data->identity);

        if (!$this->canBeCreate(
            $subject->getType(),
            $subject->getIdentity(),
            $user_info
        )) {
            throw new DublicateExeption('Duplicated verification.');
        }
        $verification = Verification::create(Uuid::v4(), $subject, false, rand(1000, 9999), $user_info);
        $this->verificationRepository->createVerification($verification);

        $listener = new VerificationCreatedListener();
        $this->dispatcher->add('VerificationCreated', $listener);
        $this->dispatcher->dispatch($verification->releaseEvents());
        return $verification;
    }

    public function confirm($id, $data)
    {
        $code = ConfirmDto::fromArray($data)->getCode();
        if ($verification = $this->verificationRepository->findVerificationById($id)) {
            if (time() - $verification->getCreatedAt()->getTimestamp() >= $this->params->get('app.verification_ttl')) {
                throw new ExpiredException();
            };
            $user_info = UserInfoDto::fromRequest($this->request);
            if(new UserInfo($user_info->getIp(), $user_info->getUserAgent()) != $verification->getUserInfo()) {
                throw new NoPermissionException();
            }

            if ($verification->getCode() != $code) {
                throw new ValidateException('Validation failed: invalid code supplied.');
            }
            $verification->confirm();
            $this->verificationRepository->updateVerification($id, $verification);
            $this->dispatcher->add('VerificationConfirmed', new VerificationConfirmedListener());
            $this->dispatcher->dispatch($verification->releaseEvents());

            return true;
        }
        throw new NotFoundHttpException('Verification not found.');
    }

    public function canBeCreate($type, $identity, UserInfo $userInfo)
    {
        $ttl = $this->params->get('app.verification_ttl');
        if ($this->verificationRepository->getLastAvailableVerification($type, $identity, $userInfo, $ttl)) {
            return false;
        }
        return true;
    }
}