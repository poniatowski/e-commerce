<?php namespace App\Tests\src\Handler\Product;


use App\Entity\Product;
use App\Service\MailerService;
use App\Handler\Product\SendProductEmailHandler;
use Codeception\Test\Unit;
use DateTimeImmutable;
use Exception;
use Psr\Log\LoggerInterface;

class SendProductEmailHandlerTest extends Unit
{
    public function testSendEmailOnSuccess(): void
    {
        $mailerServiceMock = $this->createMock(MailerService::class);
        $loggerMock        = $this->createMock(LoggerInterface::class);

        $mailerServiceMock->expects($this->once())
            ->method('send');


        $product = new Product();
        $product->setId(99999);
        $product->setName('Product title');
        $product->setDescription('Description Description Description Description Description Description Description Description Description Description');
        $product->setPrice(9.99);
        $product->setCurrency('PLN');
        $product->setCreated(new DateTimeImmutable());


        $userHandler = new SendProductEmailHandler($mailerServiceMock, $loggerMock);
        $userHandler->sendForgottenPassword('user@domain.co.uk', $product);
    }

    public function testSendEmailOnException(): void
    {
        $mailerServiceMock = $this->createMock(MailerService::class);
        $loggerMock        = $this->createMock(LoggerInterface::class);

        $mailerServiceMock->expects($this->once())
            ->method('send')
            ->will($this->throwException(new Exception('Fatal error')));


        $userHandler = new SendProductEmailHandler($mailerServiceMock, $loggerMock);
        $userHandler->sendForgottenPassword('user@domain.co.uk', new Product());
    }
}
