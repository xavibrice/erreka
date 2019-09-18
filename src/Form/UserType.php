<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('company', EntityType::class, [
                'label' => ' ',
                'class' => Company::class,
                'empty_data' => false,
                'placeholder' => 'Selecciona una empresa',
            ])
            ->add('firstName', TextType::class, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Nombres'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Apellidos'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => "Correo"
                ]
            ])
            ->add('username', TextType::class, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => "Nombre Usuario"
                ]
            ])
            ->add('active', CheckboxType::class, [
                'attr' => [
                    'checked'   => 'checked'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => ' ',
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Empresa' => 'ROLE_COMPANY',
                    'Comercial' => 'ROLE_COMMERCIAL'
                ],
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'placeholder' => 'Selecciona un rol'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => ' ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Su contraseña debe tener al menos {{ limit }} caracteres.',
                        'max' => 4096,
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Contraseña'
                ]
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
