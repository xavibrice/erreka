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

class RateHousingType extends AbstractType
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
//                'widget' => 'single_text',
//                'format' => 'dd-MM-yyyy',
//                'html5' => false,
                'attr' => [
                    'class' => $date,
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario Vivienda / WEB',
                'required' => false,
                'attr' => [
                    'rows' => 2,
                ]
            ])
            ->add('door', EntityType::class, [
                'label' => 'Tipo Puerta',
                'class' => Door::class,
                'required' => false,
                'placeholder' => 'Seleciona Puerta'
            ])
            ->add('min_price', MoneyType::class, [
                'label' => 'Precio Mínimo',
                'required' => true
            ])
            ->add('max_price', MoneyType::class, [
                'label' => 'Precio Máximo',
                'required' => true
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Dormitorios',
                'required' => true,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('bathrooms', IntegerType::class, [
                'label' => 'Baños',
                'required' => true,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('real_meters', IntegerType::class, [
                'label' => 'M² útiles',
                'required' => true,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('terrace', CheckboxType::class, [
                'label' => 'Terraza',
                'required' => false
            ])
            ->add('balcony', CheckboxType::class, [
                'label' => 'Balcón',
                'required' => false
            ])
            ->add('storage_room', CheckboxType::class, [
                'label' => 'Trastero',
                'required' => false
            ])
            ->add('direct_garage', CheckboxType::class, [
                'label' => 'Garaje Directo',
                'required' => false
            ])
            ->add('disabled_access', CheckboxType::class, [
                'label' => 'Acceso Minusválidos',
                'required' => false
            ])
            ->add('zero_dimension', CheckboxType::class, [
                'label' => 'Cota Cero',
                'required' => false
            ])
            ->add('elevator', CheckboxType::class, [
                'label' => 'Ascensor',
                'required' => false,
            ])
            /*->add('alarmSystem', CheckboxType::class, [
                'label' => 'Sistema de alarmas',
                'required' => false
            ])
            ->add('automaticDoor', CheckboxType::class, [
                'label' => 'Puerta Automática',
                'required' => false
            ])
            ->add('airConditioning', CheckboxType::class, [
                'label' => 'Aire Acondicionado',
                'required' => false
            ])*/
            ->add('bathroomState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Baño',
                'placeholder' => 'Selecciona Estado Baños',
                'class' => ValuationStatus::class
            ])
            ->add('beenCooking', EntityType::class, [
                'required' => false,
                'label' => 'Estado Cocina',
                'placeholder' => 'Selecciona Estado Cocina',
                'class' => ValuationStatus::class
            ])
            ->add('windowsState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Ventana',
                'placeholder' => 'Selecciona Estado Ventana',
                'class' => ValuationStatus::class
            ])
            ->add('beenWalls', EntityType::class, [
                'required' => false,
                'label' => 'Estado Paredes',
                'placeholder' => 'Selecciona Estado Paredes',
                'class' => ValuationStatus::class
            ])
            ->add('doorsState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Puertas',
                'placeholder' => 'Selecciona Estado Puertas',
                'class' => ValuationStatus::class
            ])
            ->add('groundState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Suelo',
                'placeholder' => 'Selecciona Estado Suelo',
                'class' => ValuationStatus::class
            ])
            ->add('window', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Ventana',
                'placeholder' => 'Selecciona Tipo Ventana',
                'class' => Window::class
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
                'label' => 'Antigüedad (Años)',
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
            ->add('pets', CheckboxType::class, [
                'label' => 'Mascotas',
                'required' => false
            ])
            ->add('exteriorBedrooms', IntegerType::class, [
                'label' => 'Dormitorio exterior',
                'required' => false
            ])
            ->add('exteriorCooking', CheckboxType::class, [
                'label' => 'Cocina exterior',
                'required' => false
            ])
            ->add('patioBedrooms', IntegerType::class, [
                'label' => 'Dormitorio patio/ciego',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('exteriorBathrooms', IntegerType::class, [
                'label' => 'Baño exterior',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('energyCertificate', EntityType::class, [
                'label' => 'Certificado Energético',
                'class' => EnergyCertificate::class,
                'placeholder' => 'Selecciona Certificado Energético',
            ])
            ->add('energyConsumption', NumberType::class, [
                'label' => 'Consumo de energía kWh/m2 año',
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
            ->add('wall', EntityType::class, [
                'label' => 'Tipo Pared',
                'class' => Wall::class,
                'required' => false,
                'placeholder' => 'Selecciona Pared'
            ])
            ->add('ground', EntityType::class, [
                'label' => 'Tipo Suelo',
                'class' => Ground::class,
                'required' => false,
                'placeholder' => 'Selecciona Suelo'
            ])
            ->add('buildingStructure', EntityType::class, [
                'label' => 'Tipo Estructura',
                'class' => BuildingStructure::class,
                'placeholder' => 'Seleccion Tipo Estructura',
                'required' => false
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
