<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Service\PricingStrategy;

class PricingTest extends TestCase
{
    public function testPricingStrategy()
    {
        $pricingStrategy = new PricingStrategy();

        // doit retourner 15
        $result = $pricingStrategy->getPrice(15, "Etat moyen");
        $this->assertEquals(15, $result);

        // doit retourner 17.99
        $result = $pricingStrategy->getPrice(15, "Bon état");
        $this->assertEquals(17.99, $result);

        // doit retourner 19.99
        $result = $pricingStrategy->getPrice(15, "Très bon état");
        $this->assertEquals(19.99, $result);

        // doit retourner 28.99
        $result = $pricingStrategy->getPrice(15, "Comme neuf");
        $this->assertEquals(28.99, $result);

        // doit retourner 30.98
        $result = $pricingStrategy->getPrice(15, "Neuf");
        $this->assertEquals(30.98, $result);
    }
}
