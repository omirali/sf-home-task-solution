<?php

namespace App\Infrastructure\Services;

use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\Interfaces\NotificationServiceInterface;
use App\Infrastructure\Dto\NotificationDto;
use App\Infrastructure\Repository\NotificationRepository;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotificationService implements NotificationServiceInterface
{

    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    public function __construct(HttpClientInterface $httpClient, NotificationRepository $notificationRepository)
    {
        $this->httpClient = $httpClient;
        $this->notificationRepository = $notificationRepository;
    }

    public function sendNotification($data)
    {
        $data = NotificationDto::fromArray($data);
        $body = $this->getBody($data->getCode());
        $notification = new Notification(Uuid::v4(),$data->getIdentity(),$data->getType(),$body, false);
        $this->notificationRepository->create($notification);
        $this->sendEmail($notification);
    }

    private function getBody($code)
    {
        /**
         * ToDo Перенести адресс в конфиг
         */
        $response = $this->httpClient->request(
            'POST',
            'http://nginx-php74/templates/render',
            [
                'json' => [
                    'slug' => 'mobile_confirmation' ? 'mobile-verification' : 'email-verification',
                    'variables' => [
                        'code' => $code
                    ]
                ]
            ]
        );
        return $response->getContent();
    }

    protected function sendEmail(Notification $notification)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Port = 1025;
            $mail->Host = $_ENV['MAILHOG_HOST'];
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($notification->getRecipient());     //Add a recipient
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = mb_substr($notification->getBody(), 0, 10);
            $mail->Body    = $notification->getBody();
            $mail->send();
        }catch (Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}