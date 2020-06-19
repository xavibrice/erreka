<?php

namespace App\Form;

use App\Entity\SearchReports;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchReportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', DatePickerType::class, [
                'label' => 'Fecha Inicio',
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('end', DatePickerType::class, [
                'label' => 'Fecha Fín',
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchReports::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
