<?php

namespace App\Form;

use App\Entity\RateHousing;
use App\Entity\StorageRoomLocation;
use App\Entity\TypeStorageRoom;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateHousingStorageRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $rateHousing = $options['data'] ?? null;
        $isEdit = $rateHousing && $rateHousing->getId();

        if ($isEdit) {
            $date = 'js-datepicker-empty';
        } else {
            $date = 'js-datepicker';
        }

        $builder
            ->add('visited', DatePickerType::class, [
                'label' => 'Fecha Valoración',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => $date,
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario Garaje',
                'required' => false,
                'attr' => [
                    'rows' => 2,
                ]
            ])
            ->add('min_price', MoneyType::class, [
                'label' => 'Precio',
                'required' => false
            ])
            ->add('typeStorageRoom', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Trastero',
                'placeholder' => 'Selecciona Tipo Trastero',
                'class' => TypeStorageRoom::class
            ])
            ->add('storageRoomLocation', EntityType::class, [
                'required' => false,
                'label' => 'Ubicación Trastero',
                'placeholder' => 'Selecciona Ubicación Trastero',
                'class' => StorageRoomLocation::class
            ])
            ->add('real_meters', IntegerType::class, [
                'label' => 'M² útiles',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('accesibleTwentyFourHours', CheckboxType::class, [
                'label' => 'Accesible 24 Horas',
                'required' => false
            ])
            ->add('loadingUnloadingArea', CheckboxType::class, [
                'label' => 'Zona Carga y Descarga',
                'required' => false
            ])
            ->add('alarmSystem', CheckboxType::class, [
                'label' => 'Sistema de Alarma',
                'required' => false
            ])

            ->add('antiquity', IntegerType::class, [
                'label' => 'Antigüedad',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('communityExpenses', MoneyType::class, [
                'label' => 'Gastos Comunidad',
                'required' => false
            ])
            ->add('pendingSpills', TextareaType::class, [
                'label' => 'Derrama Pendiente',
                'required' => false,
                'attr' => [
                    'rows' => 1
                ]
            ])
            ->add('amountPendingSpills', MoneyType::class, [
                'label' => 'Importe Derrama Pendiente',
                'required' => false
            ])
            ->add('spillsFuture', TextareaType::class, [
                'label' => 'Derrama Futura',
                'required' => false,
                'attr' => [
                    'rows' => 1
                ]
            ])
            ->add('administrator', TextType::class, [
                'label' => 'Administrador de Fincas',
                'required' => false
            ])
            ->add('mobileAdministrator', TelType::class, [
                'label' => 'Móvil/Teléfono',
                'required' => false
            ])
            ->add('height', NumberType::class, [
                'label' => 'Altura',
                'required' => false
            ])
            ->add('image', FileType::class, [
                'label' => 'Subir fotos',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'attr' => [
                    'accept' => 'image/*'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RateHousing::class,
        ]);
    }
}
