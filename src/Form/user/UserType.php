<?php

namespace App\Form\user;

use App\Entity\user\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
                ->add('firstname', TextType::class, array('attr' => array('autofocus' => true)))
                ->add('name', TextType::class)
                ->add('phoneNumber', TelType::class, array(
                                                            'required' => false,
                                                            'empty_data' => ''
                                                          )
                     )
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
        ;            

        if ($options['isAdmin']) 
        {
            
            $builder->add('roles', ChoiceType::class, array(
                                                                'required' => true,
                                                                'multiple' => true,
                                                                'choices' => $this->refactorRoles($options['roles'])
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
                                    'roles' => null,
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
