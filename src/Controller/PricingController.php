<?php

namespace App\Controller;

use App\Service\PricingStrategy;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PricingController extends AbstractController
{
    /**
     * @Route("/pricing", name="pricing")
     */
    public function index(PricingStrategy $pricingStrategy): Response
    {
        echo $pricingStrategy->getPrice(15, "Etat moyen") . "<br>";
        echo $pricingStrategy->getPrice(15, "Bon état") . "<br>";
        echo $pricingStrategy->getPrice(15, "Très bon état") . "<br>";
        echo $pricingStrategy->getPrice(15, "Comme neuf") . "<br>";
        echo $pricingStrategy->getPrice(15, "Neuf") . "<br>";
        exit();

        return $this->render('home.html.twig');
    }
}
