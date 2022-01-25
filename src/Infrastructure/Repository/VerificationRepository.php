<?php

namespace App\Infrastructure\Repository;

use App\Domain\Verification\Interfaces\VerificationRepositoryInterface;
use App\Domain\Verification\ObjectValue\Subject;
use App\Domain\Verification\ObjectValue\UserInfo;
use App\Entity\Verification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Verification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Verification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Verification[]    findAll()
 * @method Verification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerificationRepository extends ServiceEntityRepository implements VerificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Verification::class);
    }

    /**
     * @param $data \App\Domain\Verification\Entity\Verification
     */
    public function createVerification($data)
    {
        $verification = new Verification();
        $verification->setId($data->getId());
        $verification->setCode($data->getCode());
        $verification->setConfirmed($data->getConfirmed());
        $verification->setIdentity($data->getSubject()->getIdentity());
        $verification->setType($data->getSubject()->getType());
        $verification->setUserInfo($data->getUserInfo());
        $verification->setCreatedAt(new \DateTimeImmutable());
        $this->_em->persist($verification);
        $this->_em->flush();
    }

    public function findVerificationById($id)
    {
        if($data = $this->findOneBy(['id' => $id, 'confirmed' => 0])) {
            return new \App\Domain\Verification\Entity\Verification(
                $data->getId(),
                new Subject($data->getType(), $data->getIdentity()),
                $data->getConfirmed(),
                $data->getCode(),
                new UserInfo($data->getUserInfo()->ip,$data->getUserInfo()->user_agent),
                $data->getCreatedAt()
            );
        }
        return null;
    }

    public function getLastAvailableVerification($type, $identity, $userInfo, $ttl)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.type = :type')
            ->andWhere('v.identity = :identity')
            ->andWhere('v.user_info = :user_info')
            ->andWhere('v.created_at > :datetime')
            ->setParameter('type', $type)
            ->setParameter('identity', $identity)
            ->setParameter('user_info', $userInfo)
            ->setParameter('datetime', date("Y-m-d H:i:s", (time() - $ttl)))
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function updateVerification($id, ?\App\Domain\Verification\Entity\Verification $data)
    {
        if($verification = $this->findOneBy(['id' => $id])) {
            $verification->setCode($data->getCode());
            $verification->setConfirmed($data->getConfirmed());
            $verification->setIdentity($data->getSubject()->getIdentity());
            $verification->setType($data->getSubject()->getType());
            $verification->setUserInfo($data->getUserInfo());
            $verification->setUpdatedAt(new \DateTimeImmutable());
            $this->_em->persist($verification);
            $this->_em->flush();
        }
        return false;
    }
}
