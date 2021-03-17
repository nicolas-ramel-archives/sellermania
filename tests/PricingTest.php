<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Service\PricingStrategy;

class PricingTest extends TestCase
{
    public function testPricingStrategy()
    {
        $pricingStrategy = new PricingStrategy();

        // doit retourner 14.09
        $result = $pricingStrategy->getPrice(10, "Etat moyen");
        $this->assertEquals(14.09, $result);

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
