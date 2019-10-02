<?php

namespace App\Form\advert;

use App\Entity\advert\AdvertSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AdvertSimplifiedSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder 
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
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('address', HiddenType::class, array('required' => false))
            ->add('city', HiddenType::class)
            ->add('urlAjaxSession', HiddenType::class, array(
                                                                'mapped' => false,
                                                                'data' => $options['url']
                                                            )
                 )
        ;
    }           

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdvertSearch::class,
            'url' => null,
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
