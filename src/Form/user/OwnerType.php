<?php

namespace App\Form\user;

use App\Entity\user\Owner;
use App\Form\user\UserType;
use App\Form\address\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName')
            ->add('companyNumber')
            ->add('billingAddress', AddressType::class)
        ;

        if (!$options['user']->getId()) 
        {

            $builder->add('user', UserType::class, [ 'isAdmin' => $options['isAdmin'] ]);

        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
                                [
                                    'data_class' => Owner::class,
                                    'isAdmin' => null,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;
    }
}
