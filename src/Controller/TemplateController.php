<?php

namespace App\Controller;


use App\Infrastructure\Dto\TemplateDto;
use App\Infrastructure\Services\TemplateService;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class TemplateController extends Controller
{
    /**
     * @var TemplateService
     */
    private $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function render(): Response
    {
//        $mail = new PHPMailer(true);
//        try {
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//            $mail->isSMTP();
//            $mail->Port = 1025;
//            $mail->Host = $_ENV['MAILHOG_HOST'];
//            $mail->setFrom('from@example.com', 'Mailer');
//            $mail->addAddress('android.googee@gmail.com', 'Omirali Sengirbay');     //Add a recipient
//            $mail->isHTML(true);                                  //Set email format to HTML
//            $mail->Subject = 'Here is the subject';
//            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//            $mail->send();
//            echo 'Message has been sent to '. $_ENV['MAILHOG_HOST'] . ':' . 1025; die;
//        }catch (Exception $exception) {
//            dd($exception->getMessage());
//        }

        $templateDto = TemplateDto::fromArray($this->requestPayload());
        return new Response($this->templateService->render($templateDto));
    }
}