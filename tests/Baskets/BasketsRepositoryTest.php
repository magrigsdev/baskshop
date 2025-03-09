<?php

namespace App\Tests\Users\Repository;

use App\Entity\Baskets;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BasketsRepositoryTest extends KernelTestCase
{
    private $entity_manager;
    private $basket_repository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $this->entity_manager = $container->get('doctrine.orm.entity_manager');
        $this->basket_repository = $this->entity_manager->getRepository(Users::class);
    }

    protected function tearDown(): void
    {
        $users = $this->basket_repository->findAll();
        foreach ($users as $user) {
            $this->entity_manager->remove($user);
        }
        $this->entity_manager->flush();
        parent::tearDown();
    }

    public function testAddBasket(): void
    {
        $basket = new Baskets();
        $basket->setBrand("adidas");
        $basket->setColor("red, green");
        $basket->setName("derby");
        $basket->setSize("45");
        $basket->setPrice("100");
        
        dump($basket);
        $this->entity_manager->persist($basket);
        $this->entity_manager->flush();
        $this->assertNotNull($basket->getId());
    }
}
