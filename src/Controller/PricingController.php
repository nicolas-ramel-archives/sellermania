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
        $data = [];
        $data["newCompeitorName"] = "Nicolas RAMEL" ;

        // creation du formulaire
        $form = $this->createForm(PricingForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // recupère les données du formulaire
            $dataForm = $form->getData();

            // recupère le libellé de l'état du produit
            $conditionProductName = $pricingStrategy->getConditionProductName($dataForm["conditionProduct"]) ;

            // recherche le tarif suivant la stratégie de prix
            $productPrice = $pricingStrategy->getPrice($dataForm["minimumPrice"], $conditionProductName);

            // ajoute au tableau de resultat
            $pricingStrategy->addCompetitor($productPrice, $data["newCompeitorName"], $conditionProductName);

            // tri sur le tableau des concurrents par le prix
            $pricingStrategy->orderCompetitor();

            $data["competitors"] = $pricingStrategy->getCompetitors();
        }

        // transfert le formulaire à la vue
        $data['form'] = $form->createView();

        // rendu de la page
        return $this->render('home.html.twig', $data);
    }
}
