<?php

namespace App\Form\advert;

use App\Entity\advert\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('file', FileType::class, array( 
                                                    'label' => false, 
                                                    'required' => true, 
                                                    'constraints' => array(new File(),),
                                                     )
                      )
                 ->add('mainPhoto', CheckboxType::class)
                 ->add('name', HiddenType::class)  
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
            'translation_domain' => 'forms',
        ]);
    }
}
