<?php

namespace App\Form\advert;

use App\Entity\advert\Vehicle;
use App\Form\address\AddressType;
use Symfony\Component\Form\AbstractType;
use App\Repository\backend\EquipmentRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $belongingCarrier = 'Porteur';
        $belongingCell = 'Cellule';
        
        $builder
            ->add('manufactureDate', DateType::class, array(
                                                            'widget' => 'single_text', 
                                                            'html5' => false, 
                                                            'format' => 'dd/MM/yyyy',
                                                            'attr' => ['class' => 'js-datepicker'],
                                                           )
                 )        
            ->add('bedsNumber', ChoiceType::class, array('choices' => array('1' => 1, 
                                                                            '2' => 2, 
                                                                            '3' => 3, 
                                                                            '4' => 4, 
                                                                            '5' => 5, 
                                                                            '6' => 6, 
                                                                            '7' => 7, 
                                                                            '8' => 8, 
                                                                            '9' => 9, 
                                                                            '10' => 10)
                                                           )   
                 )        
            ->add('seatsNumber', ChoiceType::class, array('choices' => array('1' => 1, 
                                                                             '2' => 2, 
                                                                             '3' => 3, 
                                                                             '4' => 4, 
                                                                             '5' => 5, 
                                                                             '6' => 6, 
                                                                             '7' => 7, 
                                                                             '8' => 8, 
                                                                             '9' => 9, 
                                                                             '10' => 10)
                                                         )
                 )
            ->add('sort', EntityType::class, array(
                                                   'class' => 'App\Entity\backend\Sort', 
                                                   'choice_label' => 'sort'
                                                  )
                 )
            ->add('fuel', EntityType::class, array(
                                                   'class' => 'App\Entity\backend\Fuel', 
                                                   'choice_label' => 'fuel'
                                                  )
                 )
            ->add('mark', EntityType::class, array(
                                                   'class' => 'App\Entity\backend\Mark', 
                                                   'choice_label' => 'mark'
                                                  )
                 )        
            ->add('length')       
            ->add('height')      
            ->add('weight')     
            ->add('power')       
            ->add('gearbox', ChoiceType::class, array('choices'  => array(
                                                                          'Automatique' => 'Automatique', 
                                                                          'Manuelle' => 'Manuelle'
                                                                         ),
                                                      )
                 )
            ->add('equipments', EntityType::class, array('class' => 'App\Entity\backend\Equipment', 
                                                                    'multiple' => true, 
                                                                    'expanded' => true, 
                                                                    'choice_label' => 'equipment',
                                                                    'by_reference' => false, 
                                                                    'query_builder' => function(EquipmentRepository $er) use ($belongingCarrier) {
                                                                                            return $er->queryFindByBelonging($belongingCarrier);
                                                                                    }           
                                                                )
                 )            
            ->add('cellEquipments', EntityType::class, array(
                                                             'class' => 'App\Entity\backend\Equipment', 
                                                             'mapped' => false, 
                                                             'multiple' => true, 
                                                             'expanded' => true, 
                                                             'choice_label' => 'equipment',
                                                             'by_reference' => false,
                                                             'query_builder' => function(EquipmentRepository $er) use ($belongingCell) {
                                                                                    return $er->queryFindByBelonging($belongingCell);
                                                                                }            
                                                            )
                 )
            ->add('situation', AddressType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
            'translation_domain' => 'forms',
        ]);
    }
}
