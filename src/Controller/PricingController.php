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

        // Form creation
        $form = $this->createForm(PricingForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // retrieves the data from the form
            $dataForm = $form->getData();

            // retrieve the label of the product condition
            $conditionProductName = $pricingStrategy->getConditionProductName($dataForm["conditionProduct"]) ;

            // search the price according to the price strategy
            $productPrice = $pricingStrategy->getPrice($dataForm["minimumPrice"], $conditionProductName);

            // add result to competitor array
            $pricingStrategy->addCompetitor($productPrice, $data["newCompeitorName"], $conditionProductName);

            // sorting on the competitor array by price
            $pricingStrategy->orderCompetitor();

            $data["competitors"] = $pricingStrategy->getCompetitors();
        }

        // send data to view
        $data['form'] = $form->createView();

        // render the page
        return $this->render('home.html.twig', $data);
    }
}
