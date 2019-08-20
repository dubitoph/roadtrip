<?php

namespace App\Form\advert;

use App\Entity\advert\Advert;
use App\Form\advert\PeriodType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
                                                            'constraints' => array(new Valid()),                                                              
                                                            'entry_options'  => array('endDate' => $options['endDate']),
                                                         )
                 )
            ->add('upLimitCreation', DateTimeType::class, array(
                                                                'widget' => 'single_text', 
                                                                'html5' => false,
                                                                'attr' => array('style' => 'display: none'),
                                                                'data' => $options['endDate'],
                                                                'label' => false,
                                                                'mapped' => false
                                                               )
                 )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => Advert::class,
                                    'endDate' => null,
                                    'translation_domain' => 'forms'
                                ]
                              )
    ;

    }
    
}
