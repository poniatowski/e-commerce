<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $currencies = ['PLN', 'GBP', 'EUR'];

        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setCurrency($currencies[array_rand($currencies)]);
            $product->setDescription(
                'Description Description Description Description Description 
                Description Description Description Description Description ' . $i
            );
            $product->setPrice( rand(1, 9999));
            $product->setCreated(new DateTimeImmutable());

            $manager->persist($product);
        }

        $manager->flush();
    }
}
