<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PricingStrategy;
use App\Form\PricingForm;

class PricingController extends AbstractController
{
    /**
     * @Route("/", name="pricing")
     */
    public function index(PricingStrategy $pricingStrategy, Request $request): Response
    {
        // creation du formulaire
        $form = $this->createForm(PricingForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
        }

        // rendu de la page
        return $this->render('home.html.twig', ['form' => $form->createView()]);
    }
}
