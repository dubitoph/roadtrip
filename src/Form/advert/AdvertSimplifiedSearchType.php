<?php

namespace App\Form\advert;

use App\Entity\advert\AdvertSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
//use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AdvertSimplifiedSearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
/*
            ->add('beginAt', DateTimeType::class, array(
                                                            'widget' => 'single_text',
                                                            'html5' => false,
                                                            'attr' => [
                                                                        'class' => 'js-datepicker',
                                                                        'readonly' => true
                                                                      ]
                                                       )
                 )

            ->add('endAt', DateTimeType::class, array(
                                                            'widget' => 'single_text',
                                                            'html5' => false,
                                                            'attr' => [
                                                                        'class' => 'js-datepicker',
                                                                        'readonly' => true
                                                                      ]
                                                       )
                 )
*/
            ->add('minimumBedsNumber', ChoiceType::class, [
                                                            'choices' => [
                                                                            'Mobilhome 1 place' => 1,
                                                                            'Mobilhome 2 places' => 2,
                                                                            'Mobilhome 3 places' => 3,
                                                                            'Mobilhome 4 places' => 4,
                                                                            'Mobilhome 5 places' => 5,
                                                                            'Mobilhome 6 places' => 6,
                                                                            'Mobilhome 7 places' => 7,
                                                                            'Mobilhome 8 places' => 8,
                                                                            'Mobilhome 9 places' => 9,
                                                                            'Mobilhome 10 places' => 10
                                                                        ],
                                                            'attr' => [
                                                                        'class' => 'select-hidden'
                                                                      ],
                                                            'required' => false
                                                      ]
                 )
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('address', HiddenType::class, array('required' => false))
            ->add('city', HiddenType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => AdvertSearch::class,
                                    'url' => null,
                                    'method' => 'get',
                                    'csrf_protection' => false,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

    public function getBlockPrefix()
    {

        return '';

    }
}
