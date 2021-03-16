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
     * @Route("/", name="pricing")
     */
    public function index(PricingStrategy $pricingStrategy): Response
    {
        return $this->render('home.html.twig');
    }
}
