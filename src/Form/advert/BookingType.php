<?php

namespace App\Form\advert;

use App\Entity\advert\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateType::class, array(
                                                    'widget' => 'single_text', 
                                                    'html5' => false, 
                                                    'attr' => ['class' => 'js-datepicker-date'],
                                                   )
                 )
            ->add('endAt', DateType::class, array(
                                                    'widget' => 'single_text', 
                                                    'html5' => false, 
                                                    'attr' => ['class' => 'js-datepicker-date'],
                                                 )
                 )
            ->add('title', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'translation_domain' => 'forms',
        ]);
    }
}
