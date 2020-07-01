<?php

namespace App\Form;

use App\Entity\Charge;
use App\Entity\Offered;
use App\Entity\Property;
use App\Form\Type\DatePickerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created', DatePickerType::class, [
                'label' => 'Fecha creación',
                'data' => new \DateTime(),
                'attr' => [
                'class' => 'js-datepicker',
                    ],
                ])
            ->add('charge', EntityType::class, [
                'label' => 'Encargo',
                'class' => Charge::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->innerJoin('c.property', 'p')
                        ->innerJoin('p.street', 's')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'property',
                'placeholder' => 'Selecciona Encargo',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offered::class,
        ]);
    }
}
