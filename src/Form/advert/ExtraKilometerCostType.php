<?php

namespace App\Form\advert;

use App\Entity\advert\Advert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ExtraKilometerCostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('extraKilometerCost', NumberType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => Advert::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }
    
}
