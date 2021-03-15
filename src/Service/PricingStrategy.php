<?php
namespace App\Service;

class PricingStrategy
{
    private $priceReductionSameState = 0.01 ;
    private $priceReductionHigherState = 1 ;

    public function getPrice(float $minimumPrice, string $state): float {
        $bestPrice = null ;

        $currentLevelObject = $this->getStateObjectLevel($state);
        
        foreach ($this->getCompetitors() as $competitor) {
            // search for the best price with the same condition
            if ($competitor["state"] == $state) {
                if (!$bestPrice || $bestPrice > $competitor["price"] - $this->priceReductionSameState) {
                    $bestPrice = $competitor["price"] - $this->priceReductionSameState ;
                }
            }

            // search the best prices for the best states
            if ($this->getStateObjectLevel($competitor["state"]) > $currentLevelObject) {
                if (!$bestPrice || $bestPrice > $competitor["price"] - $this->priceReductionHigherState) {
                    $bestPrice = $competitor["price"] - $this->priceReductionHigherState ;
                }
            }
        }

        return !$bestPrice || $bestPrice < $minimumPrice ? $minimumPrice : $bestPrice;
    }

    public function getCompetitors() {
        return [
            [
                "price" => 14.1, 
                "competitor" => "Abc jeux",
                "state" => "Etat moyen"
            ],
            [
                "price" => 16.2, 
                "competitor" => "Games-planete",
                "state" => "Etat moyen"
            ],
            [
                "price" => 18, 
                "competitor" => "Media-games",
                "state" => "Bon état"
            ],
            [
                "price" => 20, 
                "competitor" => "Micro-jeux",
                "state" => "Très bon état"
            ],
            [
                "price" => 21.5, 
                "competitor" => "Top-Jeux-video",
                "state" => "Très bon état"
            ],
            [
                "price" => 24.44, 
                "competitor" => "Tous-les-jeux",
                "state" => "Bon état"
            ],
            [
                "price" => 29, 
                "competitor" => "Diffusion-133",
                "state" => "Comme neuf"
            ],
            [
                "price" => 30.99, 
                "competitor" => "France-video",
                "state" => "Neuf"
            ]
        ];
    }

    public function getStateObject() {
        return [
            "Etat moyen" => 1,
            "Bon état" => 2,
            "Très bon état" => 3,
            "Comme neuf" => 4,
            "Neuf" => 5
        ];
    }

    private function getStateObjectLevel(string $stateToSearch): int {
        $states = $this->getStateObject() ;
        return isset($states[$stateToSearch]) ? $states[$stateToSearch] : -1;
    }
}