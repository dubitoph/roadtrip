<?php

namespace App\Form\advert;

use App\Entity\advert\AdvertSearch;
use App\Repository\backend\EquipmentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AdvertSearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $belongingCarrier = 'Porteur';
        $belongingCell = 'Cellule';

        $builder
            ->add('beginAt', DateTimeType::class, array(
                                                            'widget' => 'single_text',
                                                            'html5' => false,
                                                            'attr' => [
                                                                        'class' => 'js-datepicker',
                                                                        'readonly' => true
                                                                      ],
                                                            'required' => false
                                                       )
                 )
            ->add('endAt', DateTimeType::class, array(
                                                        'widget' => 'single_text',
                                                        'html5' => false,
                                                        'attr' => [
                                                                    'class' => 'js-datepicker',
                                                                    'readonly' => true
                                                                  ],
                                                        'required' => false
                                                     )
                 )
            ->add('minimumBedsNumber', ChoiceType::class, [
                                                            'placeholder' => 'Choose an option',
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
            ->add('maximumPrice', IntegerType::class, [
                                                        'required' => false,
                                                        'attr' => ['placeholder' => 'Maximum price']
                                                      ]
                 )
            ->add('minimumPrice', IntegerType::class, [
                                                        'required' => false,
                                                        'attr' => ['placeholder' => 'Minimum price']
                                                      ]
                      )
            ->add('cellEquipments', EntityType::class, [
                                                            'required' => false,
                                                            'attr' => [
                                                                        'class' => 'select-hidden'
                                                                      ],
                                                            'class' => 'App\Entity\backend\Equipment',
                                                            'expanded' => true,
                                                            'multiple' => true,
                                                            'query_builder' => function(EquipmentRepository $er) use ($belongingCell) {
                                                                                    return $er->queryFindByBelonging($belongingCell);
                                                                            }
                                                       ]
                 )
            ->add('carrierEquipments', EntityType::class, [
                                                            'required' => false,
                                                            'class' => 'App\Entity\backend\Equipment',
                                                            'choice_label' => 'equipment',
                                                            'expanded' => true,
                                                            'multiple' => true,
                                                            'query_builder' => function(EquipmentRepository $er) use ($belongingCarrier) {
                                                                                   return $er->queryFindByBelonging($belongingCarrier);
                                                                               }
                                                          ]
                 )
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('distance', NumberType::class, array('required' => false)
                 )
            ->add('address', TextType::class, array('required' => false))
            ->add('city', HiddenType::class)
            ->add('sorting', ChoiceType::class, [
                                                  'placeholder' => 'Choose an option',
                                                  'choices' => [
                                                                  'Proximity'  => 'Proximity',
                                                                  'Price'  => 'Price',
                                                                  'Proximity + price'  => 'Proximity + price'
                                                               ],
                                                  'attr' => [
                                                              'class' => 'select-hidden'
                                                            ],
                                                  'required' => false
                                                ]
                 )
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
