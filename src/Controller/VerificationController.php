<?php
namespace App\Controller;

use App\Infrastructure\Services\VerificationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VerificationController extends Controller
{
    /**
     * @var VerificationService
     */
    private $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function createVerification()
    {
        $verification = $this->verificationService->create($this->requestPayload());
        return new JsonResponse([
            "id" => $verification->getId()
        ]);
    }

    public function checkVerification($id)
    {
        $this->verificationService->confirm($id, $this->requestPayload());
        return new Response('',204);
    }
}