<?php
namespace App\Command;

use App\Infrastructure\Services\NotificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotificationCommand extends Command
{
    /**
     * @var NotificationService
     */
    private $notificationService;

    public function __construct(string $name = null, NotificationService $notificationService)
    {
        parent::__construct($name);
        $this->notificationService = $notificationService;
    }

    protected static $defaultName = 'app:notification';


    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $message = '{"identity":"+37120000001","type":"mobile_confirmation","code":3821}';

        $data = json_decode($message,true);
        $this->notificationService->sendNotification($data);
        return Command::SUCCESS;
    }
}