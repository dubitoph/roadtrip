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

class AdvertSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $belongingCarrier = 'Porteur';
        $belongingCell = 'Cellule';

        $builder        
            ->add('minimumBedsNumber', ChoiceType::class, [
                                                        'choices' => [
                                                                        '1' => 1, 
                                                                        '2' => 2, 
                                                                        '3' => 3, 
                                                                        '4' => 4, 
                                                                        '5' => 5, 
                                                                        '6' => 6, 
                                                                        '7' => 7, 
                                                                        '8' => 8, 
                                                                        '9' => 9, 
                                                                        '10' => 10
                                                                    ],
                                                        'required' => false,
                                                        'placeholder' => 'Minimum beds number',
                                                      ]
                 )
            ->add('maximumPrice', IntegerType::class, [
                                                    'required' => false,
                                                    'attr' => ['placeholder' => 'Maximum price',]
                                                  ]
                 )
            ->add('cellEquipments', EntityType::class, [
                                                        'required' => false,
                                                        'class' => 'App\Entity\backend\Equipment',
                                                        'choice_label' => 'equipment',
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
                                                            'multiple' => true,
                                                            'query_builder' => function(EquipmentRepository $er) use ($belongingCarrier) {
                                                                                   return $er->queryFindByBelonging($belongingCarrier);
                                                                               }
                                                          ]
                 )
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('distance', ChoiceType::class, array(
                                                       'required' => false,
                                                       'choices' => array('5 km'  => 5,
                                                                          '10 km'  => 10,
                                                                          '20 km'  => 20,
                                                                          '30 km'  => 30,
                                                                          '40 km'  => 40,
                                                                          '50 km'  => 50,
                                                                          '100 km'  => 100
                                                                         )
                                                      )
                 )
            ->add('address', TextType::class, array('required' => false))
            ->add('city', HiddenType::class)
            ->add('sorting', ChoiceType::class, array(
                                                      'required' => false,
                                                      'choices' => array('Proximity'  => 'Proximity',
                                                                         'Price'  => 'Price',
                                                                         'Proximity + price'  => 'Proximity + price'
                                                                        )
                                                     )
                 )
        ;
    }           

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdvertSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
            'translation_domain' => 'forms',
        ]);
    }

    public function getBlockPrefix()
    {

        return '';

    }
}
