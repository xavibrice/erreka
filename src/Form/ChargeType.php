<?php

namespace App\Form;

use App\Entity\Charge;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $chargeType = $options['data'] ?? null;
        $isEdit = $chargeType && $chargeType->getId();

        if ($isEdit) {
            $builder
                ->add('chargeType', EntityType::class, [
                    'label' => 'Tipo Encargo',
                    'class' => \App\Entity\ChargeType::class,
                    'placeholder' => 'Selecciona Tipo Encargo'
                ])
                ->add('startDate', DatePickerType::class, [
                    'required' => true,
                    'label' => 'Fecha Inicio',
                    'attr' => [
                        'class' => 'js-datepicker-empty'
                    ]
                ])
            ;
        } else {
            $builder
                ->add('startDate', DatePickerType::class, [
                    'required' => true,
                    'label' => 'Fecha Inicio',
                    'data' => new \DateTime(),
                    'attr' => [
                        'class' => 'js-datepicker'
                    ]
                ]);
        }

        $builder
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'required' => false
            ])
            ->add('price_ok', MoneyType::class, [
                'label' => 'Precio OK',
                'required' => false
            ])
            ->add('endDate', DatePickerType::class, [
                'label' => 'Fecha Fin',
                'required' => false,
                'attr' => [
                    'class' => 'js-datepicker-empty',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Charge::class,
        ]);
    }
}
