<?php

namespace App\Form\advert;

use App\Entity\advert\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class)
            ->add('duration', EntityType::class, array(
                                                        'class' => 'App\Entity\backend\Duration', 
                                                        'attr' => array ('readonly' => true),
                                                      )
                 )
            ->add('season', EntityType::class, array(
                                                        'class' => 'App\Entity\backend\Season', 
                                                        'attr' => array ('readonly' => true),
                                                    )
                 )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
            'translation_domain' => 'forms',
        ]);
    }
}
