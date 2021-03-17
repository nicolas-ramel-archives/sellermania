<?php

namespace App\Service;

class PricingStrategy
{
    private $competitors = [];
    private $priceReductionSameConditionProduct = 0.01;
    private $priceReductionHigherConditionProduct = 1;

    public function __construct()
    {
        // add all competitor (sample data)
        $this->addCompetitor(14.1, "Abc jeux", "Etat moyen");
        $this->addCompetitor(16.2, "Games-planete", "Etat moyen");
        $this->addCompetitor(18, "Media-games", "Bon état");
        $this->addCompetitor(20, "Micro-jeux", "Très bon état");
        $this->addCompetitor(21.5, "Top-Jeux-video", "Très bon état");
        $this->addCompetitor(24.44, "Tous-les-jeux", "Bon état");
        $this->addCompetitor(29, "Diffusion-133", "Comme neuf");
        $this->addCompetitor(30.99, "France-video", "Neuf");
    }

    // determines the selling price of an item based on a floor price and product condition
    public function getPrice(float $minimumPrice, string $conditionProduct): float
    {
        $bestPrice = null;

        $currentLevelObject = $this->getConditionProductLevel($conditionProduct);
        
        // loop with all competitors
        foreach ($this->getCompetitors() as $competitor) {
            // search for the best price with the same condition
            // set the price 0.01 € lower than the competitor
            if ($competitor["conditionProduct"] == $conditionProduct) {
                $bestPriceToTest = $competitor["price"] - $this->priceReductionSameConditionProduct ;
                if ((!$bestPrice || $bestPrice > $bestPriceToTest) && $bestPriceToTest > $minimumPrice) {
                    $bestPrice = $bestPriceToTest;
                }
            }

            // search the best prices for the best condition product
            // set the price 1 € lower than the competitor
            if ($this->getConditionProductLevel($competitor["conditionProduct"]) > $currentLevelObject) {
                $bestPriceToTest = $competitor["price"] - $this->priceReductionHigherConditionProduct ;
                if ((!$bestPrice || $bestPrice > $bestPriceToTest) && $bestPriceToTest > $minimumPrice) {
                    $bestPrice = $bestPriceToTest;
                }
            }
        }

        return !$bestPrice || $bestPrice < $minimumPrice ? $minimumPrice : $bestPrice;
    }

    // add a compititor to internal array
    public function addCompetitor(float $price, string $competitor, string $conditionProduct) {
        $this->competitors[] = [
            "price" => $price,
            "competitor" => $competitor,
            "conditionProduct" => $conditionProduct
        ];
    }

    // get all competitors set in array
    public function getCompetitors()
    {
        return $this->competitors ;
    }

    // get all condition possible Name => Lebel
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

    // return condition product label (parameter : level) 
    public function getConditionProductName(int $level): string
    {
        $conditionProductName = array_search($level, $this->getConditionProduct());
        return $conditionProductName === false ? "" : $conditionProductName ;
    }

    // return the level (parameter : condition product) 
    private function getConditionProductLevel(string $conditionProductToSearch): int
    {
        $conditionsProduct = $this->getConditionProduct();
        return isset($conditionsProduct[$conditionProductToSearch]) ? $conditionsProduct[$conditionProductToSearch] : -1;
    }

    // order competitor by price
    public function orderCompetitor() {
        usort($this->competitors, function ($a, $b) {
            if ($a["price"] == $b["price"]) {
                return 0;
            }
            return ($a["price"] < $b["price"]) ? -1 : 1;
        });
    }

    // return the position in array of competitor
    public function getBestPositionOfCompetitor(string $competitorName) {
        $position = 0 ;
        foreach ($this->getCompetitors() as $competitor) {
            $position++;
            if ($competitor["competitor"] == $competitorName) {
                return $position ;
            }
        }
        return 0;
    }
}
