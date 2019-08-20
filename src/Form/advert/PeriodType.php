<?php

namespace App\Form\advert;

use App\Entity\advert\Period;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PeriodType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('start', DateTimeType::class, array(
                                                        'widget' => 'single_text', 
                                                        'html5' => false,
                                                        'attr' => array(
                                                                            'class' => 'js-datepicker-period start',
                                                                            'readonly' => true
                                                                       ),
                                                     )
                 )
            ->add('end', DateTimeType::class, array(
                                                        'widget' => 'single_text', 
                                                        'html5' => false,
                                                        'attr' => array(
                                                                            'class' => 'js-datepicker-period end',
                                                                            'readonly' => true
                                                                       ),
                                                        'data' => $options['endDate']
                                                   )
                 )
            ->add('season', EntityType::class, array(
                                                        'class' => 'App\Entity\backend\Season', 
                                                        'choice_label' => 'season', 
                                                        'attr' => array('class' => 'periodSeason'),
                                                    )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => Period::class,
                                    'endDate' => null,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }
    
}
