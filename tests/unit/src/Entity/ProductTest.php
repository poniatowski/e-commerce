<?php namespace App\Tests\src\Entity;

use App\Entity\Product;
use Codeception\Test\Unit;
use DateTime;

class ProductTest extends Unit
{
    public function testProductEntity(): void
    {
        $createdAt = new DateTime();

        $product = new Product();
        $product->setId(99999);
        $product->setName('Product title');
        $product->setDescription('Description Description Description Description Description Description Description Description Description Description');
        $product->setPrice(9.99);
        $product->setCurrency('PLN');
        $product->setCreated($createdAt);


        $this->assertSame(99999, $product->getId());
        $this->assertSame('Product title', $product->getName());
        $this->assertSame('Description Description Description Description Description Description Description Description Description Description', $product->getDescription());
        $this->assertSame(9.99, $product->getPrice());
        $this->assertSame('PLN', $product->getCurrency());
        $this->assertSame($createdAt, $product->getCreated());
    }
}