<?php

namespace App\Form\advert;

use App\Entity\advert\Advert;
use App\Form\advert\PeriodType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PeriodsAdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periods', CollectionType::class, array(
                                                            'entry_type' => PeriodType::class,
                                                            'prototype' => true,
                                                            'allow_add' => true,
                                                            'allow_delete' => true,
                                                            'by_reference' => false,
                                                            'required' => false,
                                                            'label' => false,                                                              
                                                            'entry_options'  => array('endDate' => $options['endDate']),
                                                         )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
            'endDate' => null,
            'translation_domain' => 'forms',
        ]);
    }
}
