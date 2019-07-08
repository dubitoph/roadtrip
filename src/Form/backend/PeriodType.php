<?php

namespace App\Form\backend;

use App\Entity\advert\Period;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', DateType::class, array(
                                                'widget' => 'single_text', 
                                                'html5' => false, 
                                                'attr' => ['class' => 'js-datepicker-period'],
                                                 )
                 )
            ->add('end', DateType::class, array(
                                            'widget' => 'single_text', 
                                            'html5' => false, 
                                            'attr' => ['class' => 'js-datepicker-period'],
                                               )
                 )
            ->add('season', EntityType::class, array(
                                                    'class' => 'App\Entity\backend\Season', 
                                                    'choice_label' => 'season', 
                                                    'attr' => ['class' => 'periodSeason'],
                                                    )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Period::class,
            'translation_domain' => 'forms',
        ]);
    }
}
