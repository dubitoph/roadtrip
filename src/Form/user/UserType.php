<?php

namespace App\Form\user;

use App\Entity\user\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('firstname', TextType::class)
                ->add('name', TextType::class)
                ->add('phoneNumber', TelType::class, array(
                                                            'required' => false,
                                                            'empty_data' => ''
                                                          )
                     )
                ->add('password', PasswordType::class)
                ->add('confirmedPassword', PasswordType::class)
                ->add('email', EmailType::class)
                ->add('username', TextType::class)
        ;
            

        if ($options['isAdmin']) 
        {
            
            $builder->add('roles', ChoiceType::class, array('choices' => array(
                                                                                'Administrateur' => 'ROLE_ADMIN', 
                                                                                'Propriétaire' => 'ROLE_OWNER', 
                                                                                'Utilisateur' =>'ROLE_USER' 
                                                                              ),
                                                          )
                         )
            ;

        }
        else
        {
            
            $builder->add('termsAccepted', CheckboxType::class, [
                                                                    'mapped' => false,
                                                                    'constraints' => new IsTrue(),
                                                                ]
                         )
            ;

        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
                                [
                                    'data_class' => User::class,
                                    'isAdmin' => false,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;
    }
}
