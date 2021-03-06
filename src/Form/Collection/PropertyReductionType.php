<?php

namespace App\Form\Collection;

use App\Entity\PropertyReduction;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyReductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', MoneyType::class, [
                'label' => 'Importe rebajado'
            ])
            ->add('reductionDate', DatePickerType::class, [
                'label' => 'Fecha de rebaja',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertyReduction::class,
        ]);
    }
}
