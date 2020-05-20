<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Property;
use App\Entity\Visit;
use App\Form\Type\DatePickerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
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
//            ->add('property', EntityType::class, [
//                'label' => 'Propiedad',
//                'class' => Property::class,
//                'disabled' => true
//            ])
//            ->add('client', ClientSelectType::class, [
//                'label' => 'Cliente'
//            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'label' => 'Cliente',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.full_name', 'ASC');
                },
                'placeholder' => 'Selecciona un cliente'
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
