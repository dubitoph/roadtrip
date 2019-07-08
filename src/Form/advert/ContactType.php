<?php

namespace App\Form\advert;

use App\Entity\advert\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $belongingCarrier = 'Porteur';
        $belongingCell = 'Cellule';

        $builder        
            ->add('firstName', TextType::class)        
            ->add('lastName', TextType::class)        
            ->add('phone', TextType::class)        
            ->add('email', EmailType::class)      
            ->add('message', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'forms',
        ]);
    }
}
