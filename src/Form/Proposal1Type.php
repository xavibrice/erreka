<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Property;
use App\Entity\Proposal;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Proposal1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created', DatePickerType::class, [
                'label' => 'Fecha propuesta',
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
            ->add('client', EntityType::class, [
                'label' => 'Cliente',
                'class' => Client::class,
                'placeholder' => 'Selecciona cliente'
            ])
            ->add('property', EntityType::class, [
                'label' => 'Propiedad',
                'class' => Property::class,
                'placeholder' => 'Selecciona propiedad',
                'disabled' => true,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'scale' => 0,
            ])
            ->add('agree', CheckboxType::class, [
                'label' => '¿Propuesta aceptada?',
                'required' => false
            ])
            ->add('contract', DatePickerType::class, [
                'label' => 'Fecha contrato',
                'required' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
            ->add('scriptures', DatePickerType::class, [
                'label' => 'Fecha escrituras',
                'required' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposal::class,
        ]);
    }
}
