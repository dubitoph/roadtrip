<?php

namespace App\Form\user;

use App\Entity\user\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ShortRegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
                ->add('password', RepeatedType::class, [
                                                        'type' => PasswordType::class,
                                                        'invalid_message' => 'The password fields must match.',
                                                        'options' => ['attr' => ['class' => 'password-field']],
                                                        'required' => true,
                                                        'first_options'  => ['label' => 'Password'],
                                                        'second_options' => ['label' => 'Repeat your password']
                                                       ]
                     )
                ->add('email', EmailType::class)
                ->add('username', TextType::class)
                ->add('termsAccepted', CheckboxType::class, [
                                                                'mapped' => false,
                                                                'constraints' => new IsTrue()
                                                            ]
                     )
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => User::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

    private function refactorRoles($originRoles)
    {

        $roles = array();
        $rolesAdded = array();
    
        // Add herited roles
        foreach ($originRoles as $roleParent => $rolesHerit) 
        {

            $tmpRoles = array_values($rolesHerit);
            $rolesAdded = array_merge($rolesAdded, $tmpRoles);
            $roles[$roleParent] = array_combine($tmpRoles, $tmpRoles);

        }

        // Add missing superparent roles
        $rolesParent = array_keys($originRoles);

        foreach ($rolesParent as $roleParent) 
        {

            if (!in_array($roleParent, $rolesAdded)) 
            {

                $roles['-----'][$roleParent] = $roleParent;

            }

        }
    
        return $roles;

    }
    
}
