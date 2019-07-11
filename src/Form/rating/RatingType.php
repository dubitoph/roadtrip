<?php

namespace App\Form\rating;

use App\Entity\rating\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextareaType::class)
            ->add('score', ChoiceType::class, array('choices' => array('0' => 0, 
                                                                       '1' => 1, 
                                                                       '2' => 2, 
                                                                       '3' => 3, 
                                                                       '4' => 4, 
                                                                       '5' => 5
                                                                      )
                                                   )
                 )
            ->add('rentalBeginning', DateType::class, array(
                                                            'widget' => 'single_text', 
                                                            'html5' => false, 
                                                            'attr' => ['class' => 'js-datepicker'],
                                                           )
                 )
            ->add('rentalEnd', DateType::class, array(
                                                        'widget' => 'single_text', 
                                                        'html5' => false, 
                                                        'attr' => ['class' => 'js-datepicker'],
                                                     )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
            'translation_domain' => 'forms'
        ]);
    }
}
