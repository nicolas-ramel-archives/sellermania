<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Service\PricingStrategy;

class PricingForm extends AbstractType
{
    private $pricingStrategy ;

    function __construct(PricingStrategy $pricingStrategy) {
        $this->pricingStrategy = $pricingStrategy ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minimumPrice', NumberType::class, [
                'row_attr' => ['class' => 'mb-3'],
                'label' => "Prix plancher",
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control']
            ])
            
            ->add('conditionProduct', ChoiceType::class, [
                'row_attr' => ['class' => 'mb-3'],
                'label' => "État du produit",
                'label_attr' => ['class' => 'form-label'],
                'choices'  => $this->pricingStrategy->getConditionProduct(),
                'attr' => ['class' => 'form-control']
            ])

            ->add('comparer', SubmitType::class, ['label' => 'Comparer']);
    }
}
