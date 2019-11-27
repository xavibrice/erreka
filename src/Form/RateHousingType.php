<?php

namespace App\Form;

use App\Entity\Heating;
use App\Entity\Orientation;
use App\Entity\RateHousing;
use App\Entity\ValuationStatus;
use App\Entity\Window;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
            ->add('visited', DateType::class, [
                'label' => 'Fecha Valoración',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => $date,
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
            ->add('min_price', MoneyType::class, [
                'label' => 'Precio Mínimo',
                'required' => false
            ])
            ->add('max_price', MoneyType::class, [
                'label' => 'Precio Máximo',
                'required' => false
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Dormitorios',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('bathrooms', IntegerType::class, [
                'label' => 'Baños',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('real_meters', IntegerType::class, [
                'label' => 'Metros Reales',
                'required' => false,
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('terrace', CheckboxType::class, [
                'label' => 'Terraza',
                'required' => false
            ])
            ->add('suit_bathroom', CheckboxType::class, [
                'label' => 'Baño en suit',
                'required' => false
            ])
            ->add('video_intercom', CheckboxType::class, [
                'label' => 'Videoportero',
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
                'placeholder' => 'Estado Baños',
                'class' => ValuationStatus::class
            ])
            ->add('beenCooking', EntityType::class, [
                'required' => false,
                'label' => 'Estado Cocina',
                'placeholder' => 'Estado Cocina',
                'class' => ValuationStatus::class
            ])
            ->add('windowsState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Ventanas',
                'placeholder' => 'Estado Ventanas',
                'class' => ValuationStatus::class
            ])
            ->add('beenWalls', EntityType::class, [
                'required' => false,
                'label' => 'Estado Paredes',
                'placeholder' => 'Estado Paredes',
                'class' => ValuationStatus::class
            ])
            ->add('doorsState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Puertas',
                'placeholder' => 'Estado Puertas',
                'class' => ValuationStatus::class
            ])
            ->add('groundState', EntityType::class, [
                'required' => false,
                'label' => 'Estado Suelo',
                'placeholder' => 'Estado Suelo',
                'class' => ValuationStatus::class
            ])
            ->add('window', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Ventana',
                'placeholder' => 'Tipo Ventana',
                'class' => Window::class
            ])
            ->add('heating', EntityType::class, [
                'required' => false,
                'label' => 'Tipo Calefacción',
                'placeholder' => 'Tipo Calefacción',
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
                'required' => false
            ])
            ->add('amountPendingSpills', MoneyType::class, [
                'label' => 'Importe Derrama Pendiente',
                'required' => false
            ])
            ->add('spillsFuture', TextareaType::class, [
                'label' => 'Derrama Futura',
                'required' => false
            ])
            ->add('administrator', TextType::class, [
                'label' => 'Administrador de Fincas',
                'required' => false
            ])
            ->add('mobileAdministrator', TelType::class, [
                'label' => 'Móvil/Teléfono',
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
