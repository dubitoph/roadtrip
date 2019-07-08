<?php

namespace App\Form\backend;

use App\Entity\backend\VAT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VATType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state')
            ->add('abbreviation')
            ->add('vat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VAT::class,
            'translation_domain' => 'forms',
        ]);
    }
}
