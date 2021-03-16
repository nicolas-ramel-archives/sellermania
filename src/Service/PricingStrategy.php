<?php

namespace App\Service;

class PricingStrategy
{
    private $competitors = [];
    private $priceReductionSameConditionProduct = 0.01;
    private $priceReductionHigherConditionProduct = 1;

    public function __construct()
    {
        $this->addCompetitor(14.1, "Abc jeux", "Etat moyen");
        $this->addCompetitor(16.2, "Games-planete", "Etat moyen");
        $this->addCompetitor(18, "Media-games", "Bon état");
        $this->addCompetitor(20, "Micro-jeux", "Très bon état");
        $this->addCompetitor(21.5, "Top-Jeux-video", "Très bon état");
        $this->addCompetitor(24.44, "Tous-les-jeux", "Bon état");
        $this->addCompetitor(29, "Diffusion-133", "Comme neuf");
        $this->addCompetitor(30.99, "France-video", "Neuf");
    }

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

    public function addCompetitor(float $price, string $competitor, string $conditionProduct) {
        $this->competitors[] = [
            "price" => $price,
            "competitor" => $competitor,
            "conditionProduct" => $conditionProduct
        ];
    }

    public function getCompetitors()
    {
        return $this->competitors ;
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

    public function getConditionProductName(int $level): string
    {
        $conditionProductName = array_search($level, $this->getConditionProduct());
        return $conditionProductName === false ? "" : $conditionProductName ;
    }

    private function getConditionProductLevel(string $conditionProductToSearch): int
    {
        $conditionsProduct = $this->getConditionProduct();
        return isset($conditionsProduct[$conditionProductToSearch]) ? $conditionsProduct[$conditionProductToSearch] : -1;
    }

    public function orderCompetitor() {
        usort($this->competitors, function ($a, $b) {
            if ($a["price"] == $b["price"]) {
                return 0;
            }
            return ($a["price"] < $b["price"]) ? -1 : 1;
        });
    }
}
