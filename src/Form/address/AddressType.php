<?php

namespace App\Form\address;

use App\Entity\address\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
            ->add('street')
            ->add('number')
            ->add('box')
            ->add('zipCode')
            ->add('city')
            ->add('state')
            ->add('country', CountryType::class, array(
                                                        'required' => true, 
                                                      )
                 )
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'translation_domain' => 'forms',
        ]);
    }
}
