<?php

namespace App\Form\security;

use App\Entity\user\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordResettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('password', PasswordType::class)
                ->add('confirmedPassword', PasswordType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                'data_class' => User::class,
                                'translation_domain' => 'forms',
                               ])
        ;
    }
}