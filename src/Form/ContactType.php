<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control-a',
                    'placeholder' => 'Nombre completo'
                ]
            ])
            ->add('mobile', TelType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control-a',
                    'placeholder' => 'Móvil o Teléfono'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'class' => 'form-control-a',
                    'placeholder' => 'Correo'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Comentario',
                    'rows' => 8,
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
