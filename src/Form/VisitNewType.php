<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Property;
use App\Entity\Visit;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visited', DatePickerType::class, [
                'required' => true,
                'label' => 'Fecha Visita',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
            ->add('property', PropertySelectType::class, [
                'label' => 'Propiedad',
            ])
            ->add('client', EntityType::class, [
                'label' => 'Cliente',
                'class' => Client::class,
                'disabled' => true
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
