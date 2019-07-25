<?php

namespace App\Form\address;

use App\Entity\address\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
            ->add('street', TextType::class)
            ->add('number', TextType::class)
            ->add('box', NumberType::class)
            ->add('zipCode', TextType::class)
            ->add('city', TextType::class)
            ->add('state', TextType::class)
            ->add('country', CountryType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
        ;

        if($options['userProfile'])
        {

            $builder->add('defaultUserLocation', CheckboxType::class);

        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'userProfile' => false,
            'translation_domain' => 'forms',
        ]);
    }
}
