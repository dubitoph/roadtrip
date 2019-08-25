<?php

namespace App\Form\advert;

use App\Entity\advert\IncludedMileage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class IncludedMileageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('mileage', NumberType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => IncludedMileage::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }
    
}
