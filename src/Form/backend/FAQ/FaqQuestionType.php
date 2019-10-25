<?php

namespace App\Form\backend\FAQ;

use App\Entity\backend\FAQ\FaqQuestion;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FaqQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('question', TextType::class)
            ->add('answer', CKEditorType::class, array('config_name' => 'admin_config'))
            ->add('category', EntityType::class, [
                                                    'class' => 'App\Entity\backend\FAQ\FaqCategory',
                                                    'choice_label' => 'category'
                                                 ]
                 )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => FaqQuestion::class,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

}
