<?php

namespace App\Form\user;

use App\Entity\user\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('firstname', TextType::class, array('attr' => array ('readonly' => true),))
                ->add('name', TextType::class, array('attr' => array ('readonly' => true),))
                ->add('phoneNumber', TelType::class, array(
                                                            'required' => false,
                                                            'empty_data' => ''
                                                          )
                     )
                ->add('email', EmailType::class)
                ->add('username')
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
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,
            'translation_domain' => 'forms',
        ]);
    }
}
