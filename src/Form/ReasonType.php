<?php

namespace App\Form;

use App\Entity\Reason;
use App\Entity\Situation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('situation', EntityType::class, [
                'label' => 'Situación',
                'class' => Situation::class,
                'placeholder' => 'Selecciona una situación'
            ])
            ->add('name', TextType::class, [
                'label' => 'Motivo',
                'attr' => [
                    'placeholder' => 'Nombre'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reason::class,
        ]);
    }
}
