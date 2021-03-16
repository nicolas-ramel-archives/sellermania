<?php

namespace App\Service;

class PricingStrategy
{
    private $priceReductionSameConditionProduct = 0.01;
    private $priceReductionHigherConditionProduct = 1;

    public function getPrice(float $minimumPrice, string $conditionProduct): float
    {
        $bestPrice = null;

        $currentLevelObject = $this->getConditionProductLevel($conditionProduct);

        foreach ($this->getCompetitors() as $competitor) {
            // search for the best price with the same condition
            if ($competitor["conditionProduct"] == $conditionProduct) {
                if (!$bestPrice || $bestPrice > $competitor["price"] - $this->priceReductionSameConditionProduct) {
                    $bestPrice = $competitor["price"] - $this->priceReductionSameConditionProduct;
                }
            }

            // search the best prices for the best condition product
            if ($this->getConditionProductLevel($competitor["conditionProduct"]) > $currentLevelObject) {
                if (!$bestPrice || $bestPrice > $competitor["price"] - $this->priceReductionHigherConditionProduct) {
                    $bestPrice = $competitor["price"] - $this->priceReductionHigherConditionProduct;
                }
            }
        }

        return !$bestPrice || $bestPrice < $minimumPrice ? $minimumPrice : $bestPrice;
    }

    public function getCompetitors()
    {
        return [
            [
                "price" => 14.1,
                "competitor" => "Abc jeux",
                "conditionProduct" => "Etat moyen"
            ],
            [
                "price" => 16.2,
                "competitor" => "Games-planete",
                "conditionProduct" => "Etat moyen"
            ],
            [
                "price" => 18,
                "competitor" => "Media-games",
                "conditionProduct" => "Bon état"
            ],
            [
                "price" => 20,
                "competitor" => "Micro-jeux",
                "conditionProduct" => "Très bon état"
            ],
            [
                "price" => 21.5,
                "competitor" => "Top-Jeux-video",
                "conditionProduct" => "Très bon état"
            ],
            [
                "price" => 24.44,
                "competitor" => "Tous-les-jeux",
                "conditionProduct" => "Bon état"
            ],
            [
                "price" => 29,
                "competitor" => "Diffusion-133",
                "conditionProduct" => "Comme neuf"
            ],
            [
                "price" => 30.99,
                "competitor" => "France-video",
                "conditionProduct" => "Neuf"
            ]
        ];
    }

    public function getConditionProduct()
    {
        return [
            "Etat moyen" => 1,
            "Bon état" => 2,
            "Très bon état" => 3,
            "Comme neuf" => 4,
            "Neuf" => 5
        ];
    }

    private function getConditionProductLevel(string $conditionProductToSearch): int
    {
        $conditionsProduct = $this->getConditionProduct();
        return isset($conditionsProduct[$conditionProductToSearch]) ? $conditionsProduct[$conditionProductToSearch] : -1;
    }
}
