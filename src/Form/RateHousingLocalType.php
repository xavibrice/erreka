<?php

namespace App\Form;

use App\Entity\BuildingStructure;
use App\Entity\Door;
use App\Entity\EnergyCertificate;
use App\Entity\Ground;
use App\Entity\Heating;
use App\Entity\Orientation;
use App\Entity\RateHousing;
use App\Entity\StateKeys;
use App\Entity\ValuationStatus;
use App\Entity\Wall;
use App\Entity\Window;
use App\Form\Type\DatePickerType;
use App\Form\Type\DateTimePickerType;
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

class RateHousingLocalType extends AbstractType
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
                'label' => 'Comentario Vivienda',
                'required' => false,
                'attr' => [
                    'rows' => 2,
                ]
            ])
            ->add('min_price', MoneyType::class, [
                'label' => 'Precio Mínimo',
                'required' => false
            ])
            ->add('max_price', MoneyType::class, [
                'label' => 'Precio Máximo',
                'required' => false
            ])
            ->add('bathrooms', IntegerType::class, [
                'label' => 'Baños',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('real_meters', IntegerType::class, [
                'label' => 'M² útiles',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])

            ->add('airConditioning', CheckboxType::class, [
                'label' => 'Aire Acondicionado',
                'required' => false
            ])
            ->add('heating', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Calefacción',
                'placeholder' => 'Selecciona Tipo Calefacción',
                'class' => Heating::class
            ])
            ->add('orientation', EntityType::class, [
                'label' => 'Orientación',
                'class' => Orientation::class,
                'placeholder' => 'Selecciona Orientación',
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
            ->add('exteriorCooking', CheckboxType::class, [
                'label' => 'Cocina exterior',
                'required' => false
            ])
            ->add('energyCertificate', EntityType::class, [
                'label' => 'Certificado Energético',
                'class' => EnergyCertificate::class,
                'required' => false,
                'placeholder' => 'Selecciona Certificado Energético',
            ])
            ->add('energyConsumption', NumberType::class, [
                'label' => 'Consumo de energía',
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
