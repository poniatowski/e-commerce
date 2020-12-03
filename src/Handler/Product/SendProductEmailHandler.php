<?php declare(strict_types=1);

namespace App\Handler\Product;

use App\Entity\Product;
use App\Service\MailerService;
use Psr\Log\LoggerInterface;
use Throwable;

final class SendProductEmailHandler
{
    private MailerService $mailerService;

    private LoggerInterface $logger;

    public function __construct(
        MailerService $mailerService,
        LoggerInterface $logger
    )
    {
        $this->mailerService = $mailerService;
        $this->logger        = $logger;
    }

    public function sendForgottenPassword(string $email, Product $product): void
    {
        try {
            $this->mailerService->send(
                $email,
                'New product has been successfully create.',
                'mails/new_product_confirmation.twig', [
                'product' => $product,
            ]);
        } catch (Throwable $e) {
            $this->logger->critical('Error occurred, please try again.',[
                'message' => $e->getMessage(),
                'email'   => $email,
            ]);
        }
    }
}
