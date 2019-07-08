<?php

namespace App\Form\advert;

use App\Entity\advert\Advert;
use App\Form\advert\PriceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PricesAdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prices', CollectionType::class, array(
                                                            'entry_type' => PriceType::class,
                                                            'prototype' => true,
                                                            'allow_add' => true,
                                                            'allow_delete' => true,
                                                            'by_reference' => false,
                                                            'required' => false,
                                                            'label' => false,  
                                                            )
                     )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
            'translation_domain' => 'forms',
        ]);
    }
}
