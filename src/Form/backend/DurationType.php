<?php

namespace App\Form\backend;

use App\Entity\backend\Duration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DurationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('duration', TextType::class)
            ->add('daysNumber', ChoiceType::class, array('choices'  => $options['missingDurations']));

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => Duration::class,
                                    'missingDurations' => null,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

}
