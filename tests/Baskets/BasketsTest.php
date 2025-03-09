<?php

namespace App\Tests\Users\Entity;

use App\Entity\Baskets;
use PHPUnit\Framework\TestCase;

class BasketsTest extends TestCase
{
    public function testBasketEntity(): void
    {
        $basket = new Baskets();
        $basket->setBrand("adidas");
        $this->assertEquals("adidas",$basket->getBrand());
    }
}
