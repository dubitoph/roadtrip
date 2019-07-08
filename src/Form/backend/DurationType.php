<?php

namespace App\Form\backend;

use App\Entity\backend\Duration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration')
            ->add('daysNumber', ChoiceType::class, array('choices'  => array('2' => 2, 
                                                                             '3' => 3,
                                                                             '4' => 4,
                                                                             '5' => 5,
                                                                             '6' => 6,
                                                                             '7' => 7
                                                                            )
                                                        )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duration::class,
            'translation_domain' => 'forms',
        ]);
    }
}
