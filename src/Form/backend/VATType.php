<?php

namespace App\Form\backend;

use App\Entity\backend\VAT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VATType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('abbreviation', CountryType::class, array(
                                                            'label' => 'State',
                                                            'choice_translation_locale' => 'en'
                                                           )
                 )
            ->add('state', HiddenType::class)
            ->add('vat', TextType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => VAT::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;
        
    }
}
