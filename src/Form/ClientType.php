<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Heating;
use App\Entity\Orientation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('full_name', TextType::class, [
                'label' => 'Cliente'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo'
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Móvil/Teléfono'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario'
            ])
            ->add('created', DateType::class, [
                'required' => true,
                'label' => false,
                'widget' => 'single_text',
                'format' => 'dd-mm-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('realMeters', IntegerType::class, [
                'label' => 'Metros'
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Habitaciones'
            ])
            ->add('bathrooms', IntegerType::class, [
                'label' => 'Baños'
            ])
            ->add('heating', EntityType::class, [
                'class' => Heating::class,
                'label' => 'Calefacción',
                'placeholder' => 'Selecciona Calefacción'
            ])
            ->add('orientation', EntityType::class, [
                'class' => Orientation::class,
                'label' => 'Selecciona Orientación',
                'placeholder' => 'Selecciona Orientación'
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
                'required' => false
            ])
//            ->add('properties')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
