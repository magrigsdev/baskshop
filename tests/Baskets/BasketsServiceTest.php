<?php

namespace App\Tests;

use App\Entity\Baskets;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BasketsServiceTest extends KernelTestCase
{
    private $entity_manager;
    private $basket_repository;
    private $project_dir;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $this->entity_manager = $container->get('doctrine.orm.entity_manager');
        $this->basket_repository = $this->entity_manager->getRepository(Baskets::class);
        $this->project_dir = $container->getParameter('kernel.project_dir');
    }

    protected function tearDown(): void
    {
        $baskets = $this->basket_repository->findAll();
        foreach ($baskets as $basket) {
            $this->entity_manager->remove($basket);
        }
        $this->entity_manager->flush();
        parent::tearDown();
    }

}
