<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User|null $user */
        $user = $options['data'] ?? null;
        $isEdit = $user && $user->getId();

        $imageContrains = [
            new Image([
                'maxSize' => '5M'
            ]),
        ];

        $passwordContrains = [
            new Length([
                'min' => 6,
                'minMessage' => 'Su contraseña debe tener al menos {{ limit }} caracteres.',
                'max' => 4096,
            ])
        ];

        if (!$isEdit || !$user->getPassword()) {
            $passwordContrains[] = new NotNull([
                'message' => 'Por favor poner una contraseña'
            ]);
        }

/*        if (!$isEdit || !$user->getImageFilename()) {
            $imageContrains[] = new NotNull([
                'message' => 'Por favor subir una foto'
            ]);
        }*/

        $builder
            ->add('imageFile', FileType::class, [
                'label' => ' ',
                'mapped' => false,
                'required' => false,
                'constraints' => $imageContrains,
                'attr' => [
                    'placeholder' => 'Selecciona una imagen'
                ],
            ])
            ->add('company', EntityType::class, [
                'label' => ' ',
                'required' => false,
                'class' => Company::class,
                'empty_data' => true,
//                'placeholder' => 'Selecciona una empresa',
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
                'constraints' => $passwordContrains,
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
