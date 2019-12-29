<?php

namespace App\Form\Collection;

use App\Entity\PropertyReduction;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyReductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', MoneyType::class, [
                'label' => 'Precio'
            ])
            ->add('reductionDate', DateTimePickerType::class, [
                'label' => 'Fecha de rebaja',
//                'widget' => 'single_text',
//                'format' => 'dd-mm-yyyy',
//                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('reductionNextDate', DateTimePickerType::class, [
                'label' => 'Fecha próxima rebaja',
//                'widget' => 'single_text',
                'required' => false,
//                'format' => 'dd-mm-yyyy',
//                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker-empty',
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
