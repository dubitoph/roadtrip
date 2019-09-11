<?php

namespace App\Form\backend;

use App\Entity\backend\Subscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('duration', ChoiceType::class, array('choices' => array(
                                                                            '1' => 1, 
                                                                            '2' => 2, 
                                                                            '3' => 3, 
                                                                            '4' => 4, 
                                                                            '5' => 5, 
                                                                            '6' => 6, 
                                                                            '7' => 7, 
                                                                            '8' => 8, 
                                                                            '9' => 9, 
                                                                            '10' => 10, 
                                                                            '11' => 11, 
                                                                            '12' => 12
                                                      )
))
            ->add('price', IntegerType::class)
            ->add('isActive', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
            'translation_domain' => 'forms',
        ]);
    }
}
