<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\RateHousing;
use App\Entity\ValuationStatus;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateHousingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visited', DateType::class, [
                'label' => 'Visitado',
                'widget' => 'single_text',
                'format' => 'dd-mm-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
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
            ->add('pets', CheckboxType::class, [
                'label' => 'Mascotas',
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
            ->add('approx_meters', IntegerType::class, [
                'label' => 'Metros Aproximados',
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
            ->add('living_room', CheckboxType::class, [
                'label' => 'Sala',
                'required' => false
            ])
            ->add('balcony', CheckboxType::class, [
                'label' => 'Balcón',
                'required' => false
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
            ->add('pantry', CheckboxType::class, [
                'label' => 'Despensa',
                'required' => false
            ])
            ->add('fitted_wardrobes', CheckboxType::class, [
                'label' => 'Armarios Empotrados',
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
            ->add('security_door', CheckboxType::class, [
                'label' => 'Puerta de Seguridad',
                'required' => false
            ])
            ->add('bathroomState', EntityType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Estado Baños',
                'class' => ValuationStatus::class
            ])
            ->add('beenCooking', EntityType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Estado Cocina ',
                'class' => ValuationStatus::class
            ])
            ->add('windowsState', EntityType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Estado Ventanas',
                'class' => ValuationStatus::class
            ])
            ->add('beenWalls', EntityType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Estado Paredes',
                'class' => ValuationStatus::class
            ])
            ->add('doorsState', EntityType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Estado Puertas',
                'class' => ValuationStatus::class
            ])
            ->add('groundState', EntityType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Estado Suelo',
                'class' => ValuationStatus::class
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
