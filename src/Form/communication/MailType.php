<?php

namespace App\Form\communication;

use App\Entity\communication\Mail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if (! $options['existingSubject']) 
        {

            $builder->add('subject', TextType::class);

        }
        
        $builder->add('message', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                'data_class' => Mail::class,
                                'existingSubject' => true,
                                'translation_domain' => 'forms'
                               ]);
    }
}
