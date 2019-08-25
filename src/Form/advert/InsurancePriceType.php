<?php

namespace App\Form\advert;

use App\Entity\advert\InsurancePrice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InsurancePriceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('price', NumberType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => InsurancePrice::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

}
