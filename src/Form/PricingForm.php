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
            ->add('minimumPrice', NumberType::class)
            ->add('conditionProduct', ChoiceType::class, [
                'choices'  => $this->pricingStrategy->getConditionProduct(),
            ])
            ->add('save', SubmitType::class, ['label' => 'Comparer']);
    }
}
