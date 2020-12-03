<?php declare(strict_types=1);

namespace App\Notification\Event;

use App\Entity\Product;
use Symfony\Contracts\EventDispatcher\Event;

class NewProductArrivedEvent extends Event
{
    public const NAME = 'new.product.event';

    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
