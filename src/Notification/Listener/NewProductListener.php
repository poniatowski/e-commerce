<?php declare(strict_types=1);

namespace App\Notification\Listener;

use App\Handler\Product\SendProductEmailHandler;
use Symfony\Contracts\EventDispatcher\Event;

class NewProductListener
{
    private SendProductEmailHandler $emailHandler;

    public function __construct(SendProductEmailHandler $emailHandler)
    {
        $this->emailHandler = $emailHandler;
    }

    public function onNewProductEvent(Event $event): void
    {
        $this->emailHandler->sendForgottenPassword($_ENV['MAILER_SENDER_ADDRESS'], $event->getProduct());
    }
}