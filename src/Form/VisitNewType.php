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
//            ->add('property', PropertySelectType::class, [
//                'label' => 'Propiedad',
//            ])
            ->add('property', EntityType::class, [
                'placeholder' => 'Selecciona una propiedad',
                'class' => Property::class,
                'label' => 'Propiedad',
                'query_builder' => function(EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('p')
                        ->innerJoin('p.charge', 'c')
                        ->innerJoin('c.charge_type', 'ct')
                        ->andWhere('ct.name = :name')
                        ->setParameter('name', 'autorizacion')
                        ->setParameter('name', 'exclusiva')
                        ;
                }
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
