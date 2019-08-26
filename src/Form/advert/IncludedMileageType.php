<?php

namespace App\Form\advert;

use App\Entity\advert\IncludedMileage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class IncludedMileageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('unlimited', CheckboxType::class, array(
                                                            'required' => false,
                                                            'attr' => array('class' => 'illimited_mileage_checkbox')
                                                         )
                 )
            ->add('mileage', NumberType::class, array(
                                                        'required' => false,
                                                        'attr' => array('class' => 'mileage_input')
                                                     )
                 )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => IncludedMileage::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }
    
}
