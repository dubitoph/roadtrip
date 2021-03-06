<?php

namespace App\Form\backend;

use App\Entity\backend\Sort;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sort', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(
                                [
                                    'data_class' => Sort::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }
}
