<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Nombres'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Apellidos'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo'
            ])
            ->add('username', TextType::class, [
                'label' => 'Nombre usuario'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Empresa' => 'ROLE_COMPANY',
                    'Comercial' => 'ROLE_COMMERCIAL'
                ],
                'expanded' => true,
                'multiple' => true
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Contraseña',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Su contraseña debe tener al menos {{ limit }} caracteres.',
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('company', EntityType::class, [
                'label' => 'Compañia',
                'class' => Company::class,
                'empty_data' => false,
                'placeholder' => 'Selecciona una empresa',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
