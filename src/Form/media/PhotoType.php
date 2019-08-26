<?php

namespace App\Form\media;

use App\Entity\media\Photo;
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
        $builder->add('file', FileType::class, array( 
                                                        'label' => false, 
                                                        'required' => true, 
                                                        'constraints' => array(new File(),),
                                                     )
                      )
        ;

        if(! $options['profilePhoto'])
        {

            $builder->add('mainPhoto', CheckboxType::class);

        }

                
        $builder->add('name', HiddenType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
            'profilePhoto' => false,
            'translation_domain' => 'forms',
        ]);
    }
}
