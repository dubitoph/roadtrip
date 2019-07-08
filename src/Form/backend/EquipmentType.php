<?php

namespace App\Form\backend;

use App\Entity\backend\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipment')
            ->add('belonging', ChoiceType::class, array(
                                                        'choices'  => array(
                                                                            'Porteur' => 'Porteur', 
                                                                            'Cellule' => 'Cellule',
                                                                           ), 
                                                        'placeholder' => "Veuillez choisir l'appartenance de l'équipement",
                                                       )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
            'translation_domain' => 'forms',
        ]);
    }
}
