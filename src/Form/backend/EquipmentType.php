<?php

namespace App\Form\backend;

use App\Entity\backend\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EquipmentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('equipment', TextType::class)
            ->add('belonging', ChoiceType::class, array(
                                                        'choices'  => array(
                                                                            'Carrier' => 'Carrier', 
                                                                            'Cell' => 'Cell',
                                                                           )
                                                       )
                 )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => Equipment::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

}
