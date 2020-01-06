<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Heating;
use App\Entity\Orientation;
use App\Entity\TypeProperty;
use App\Entity\User;
use App\Entity\Zone;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created', DatePickerType::class, [
                'required' => true,
                'label' => 'Fecha',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('full_name', TextType::class, [
                'label' => 'Nombre Cliente'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'required' => false
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Móvil/Teléfono',
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
            ->add('realMeters', IntegerType::class, [
                'label' => 'Metros',
                'required' => false
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Habitaciones',
                'required' => false
            ])
            ->add('bathrooms', IntegerType::class, [
                'label' => 'Baños',
                'required' => false
            ])
            ->add('heating', EntityType::class, [
                'class' => Heating::class,
                'label' => 'Calefacción',
                'placeholder' => 'Selecciona Calefacción',
                'required' => false
            ])
            ->add('orientation', EntityType::class, [
                'class' => Orientation::class,
                'label' => 'Orientación',
                'placeholder' => 'Selecciona Orientación',
                'required' => false
            ])
            ->add('terrace', CheckboxType::class, [
                'label' => 'Terraza',
                'required' => false,
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
                'required' => false
            ])
            ->add('zone', EntityType::class, [
                'label' => 'Zona',
                'class' => Zone::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('commercial', EntityType::class, [
                'label' => 'Comercial',
                'class' => User::class,
                'placeholder' => 'Selecciona un comercial'
            ])
            ->add('typeProperty', EntityType::class, [
                'label' => 'Tipo Propiedad',
                'required' => true,
                'class' => TypeProperty::class,
                'placeholder' => 'Selecciona Tipo Propiedad'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
