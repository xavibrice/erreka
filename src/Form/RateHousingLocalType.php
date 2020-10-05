<?php

namespace App\Form;

use App\Entity\EnergyCertificate;
use App\Entity\Heating;
use App\Entity\LocalGarageLocation;
use App\Entity\Orientation;
use App\Entity\RateHousing;
use App\Entity\Stays;
use App\Entity\TypeLocal;
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
                'label' => 'Comentario Local / Negocio',
                'required' => false,
                'attr' => [
                    'rows' => 2,
                ]
            ])
            ->add('min_price', MoneyType::class, [
                'label' => 'Precio',
                'required' => false
            ])
            ->add('typeLocal', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Local',
                'placeholder' => 'Selecciona Tipo Local / Negocio',
                'class' => TypeLocal::class
            ])
            ->add('stays', EntityType::class, [
                'required' => false,
                'label' => 'Estancias',
                'placeholder' => 'Selecciona Estancia',
                'class' => Stays::class
            ])
            ->add('localGarageLocation', EntityType::class, [
                'required' => false,
                'label' => 'Ubicación Local / Negocio',
                'placeholder' => 'Selecciona Ubicación Local / Negocio',
                'class' => LocalGarageLocation::class
            ])
            ->add('bathrooms', IntegerType::class, [
                'label' => 'Baños',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => 5
                ]
            ])
            ->add('real_meters', IntegerType::class, [
                'label' => 'M² útiles',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('plants', IntegerType::class, [
                'label' => 'Nº de plantas',
                'attr' => [
                    'min' => 0,
                    'max' => 3
                ]
            ])
            ->add('airConditioning', CheckboxType::class, [
                'label' => 'Aire Acondicionado',
                'required' => false
            ])
            ->add('smokeOutlet', CheckboxType::class, [
                'label' => 'Salida Humos',
                'required' => false
            ])
            ->add('alarmSystem', CheckboxType::class, [
                'label' => 'Sistema de Alarma',
                'required' => false
            ])
            ->add('equippedKitchen', CheckboxType::class, [
                'label' => 'Cocina Equipada',
                'required' => false
            ])
            ->add('corner', CheckboxType::class, [
                'label' => '¿Hace Esquina?',
                'required' => false
            ])
            ->add('closedSecurityCircuit', CheckboxType::class, [
                'label' => 'Circuito Cerrado Seguridad',
                'required' => false
            ])
            ->add('securityDoor', CheckboxType::class, [
                'label' => 'Puerta de Seguridad',
                'required' => false
            ])
            ->add('warehouse', CheckboxType::class, [
                'label' => 'Trastero',
                'required' => false
            ])
            ->add('heating', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Calefacción',
                'placeholder' => 'Selecciona Tipo Calefacción',
                'class' => Heating::class,
            ])
            ->add('orientation', EntityType::class, [
                'label' => 'Orientación',
                'class' => Orientation::class,
                'placeholder' => 'Selecciona Orientación',
                'required' => false,
            ])
            ->add('shopWindows', IntegerType::class, [
                'label' => 'Nº Escaparates',
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
