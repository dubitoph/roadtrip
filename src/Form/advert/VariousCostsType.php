<?php

namespace App\Form\advert;

use App\Form\advert\InsuranceType;
use App\Form\advert\InsurancePriceType;
use App\Form\advert\IncludedMileageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VariousCostsType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
                ->add('insurance', InsuranceType::class)
                ->add('insurancePrices', CollectionType::class, array(
                                                                        'entry_type' => InsurancePriceType::class,
                                                                        'constraints' => array(new Valid())
                                                                     )
                     )
                ->add('includedMileages', CollectionType::class, array(
                                                                        'entry_type' => IncludedMileageType::class,
                                                                        'constraints' => array(new Valid())
                                                                      )
                     )
                ->add('extraKilometerCost', ExtraKilometerCostType::class)
                ->add('cleaning', CleaningType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => null,
                                    'insurance' => null,
                                    'insurancePrices' => null,
                                    'includedMileages' => null, 
                                    'extraKilometerCost' => null,
                                    'cleaning' => null,
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }

}
