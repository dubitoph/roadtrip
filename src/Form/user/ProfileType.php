<?php

namespace App\Form\user;

use App\Entity\user\Profile;
use App\Form\media\PhotoType;
use App\Form\address\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('sex', ChoiceType::class, array(
                                                    'choices'  => [
                                                                    '-' => null,
                                                                    'Female' => 'F',
                                                                    'Male' => 'M'
                                                                  ],
                                                    'required' => false
                                                    )
            )
            ->add('birthday', DateType::class, array(
                                                        'widget' => 'single_text', 
                                                        'html5' => false, 
                                                        'format' => 'dd/MM/yyyy',
                                                        'attr' => ['class' => 'js-datepicker'],
                                                        'required' => false
                                                    )
                 )
            ->add('photo', PhotoType::class, array(
                                                    'profilePhoto' => true,
                                                    'constraints' => array(new Valid()),
                                                    'required' => false
                                                  )
                 )
            ->add('address', AddressType::class, array(
                                                        'userProfile' => true,
                                                        'constraints' => array(new Valid()),
                                                        'required' => false
                                                      )
                 )
            ->add('vehicle', TextType::class, array('required' => false))
            ->add('aboutMe', TextareaType::class, array('required' => false))
            ->add('website', TextType::class, array('required' => false))
            ->add('signature', TextType::class, array('required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
                                [
                                  'data_class' => Profile::class,
                                  'translation_domain' => 'forms'
                                ]
                              )
        ;
    }
}
