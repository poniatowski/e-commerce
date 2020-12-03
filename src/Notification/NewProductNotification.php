<?php declare(strict_types=1);

namespace App\Notification;

use App\Entity\Product;
use App\Handler\Product\SendProductEmailHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Notification\Event\NewProductArrivedEvent;
use App\Notification\Listener\NewProductListener;

final class NewProductNotification
{
    private EventDispatcherInterface $eventDispatcher;

    private SendProductEmailHandler $emailHandler;

    public function __construct(EventDispatcherInterface $eventDispatcher, SendProductEmailHandler $emailHandler)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->emailHandler    = $emailHandler;
    }

    public function sendNotifications(Product $product): void
    {
        $this->eventDispatcher->addListener(
            NewProductArrivedEvent::NAME, [(new NewProductListener($this->emailHandler)), 'onNewProductEvent']
        );

        $this->eventDispatcher->dispatch(new NewProductArrivedEvent($product), NewProductArrivedEvent::NAME);
    }
}