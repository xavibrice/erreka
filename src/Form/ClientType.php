<?php

namespace App\Form;

use App\Entity\Bedrooms;
use App\Entity\BuildingStructure;
use App\Entity\Client;
use App\Entity\ClientZone;
use App\Entity\Heating;
use App\Entity\Orientation;
use App\Entity\Reason;
use App\Entity\TypeProperty;
use App\Entity\User;
use App\Entity\Zone;
use App\Form\Type\DatePickerType;
use Doctrine\ORM\EntityRepository;
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
            ->add('reason', EntityType::class, [
                'label' => 'Motivo',
                'class' => Reason::class,
                'placeholder' => 'Selecciona un motivo',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->innerJoin('r.situation', 's')
                        ->where('s.name = :name')
                        ->setParameter('name', 'noticia')
                        ;
                }
            ])
            ->add('created', DatePickerType::class, [
                'required' => true,
                'label' => 'Fecha',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('full_name', TextType::class, [
                'label' => 'Nombre Cliente',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'required' => false,
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Móvil',
                'required' => false,
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono',
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false,
            ])
            ->add('heating', EntityType::class, [
                'class' => Heating::class,
                'label' => 'Calefacción',
                'placeholder' => 'Selecciona Calefacción',
                'required' => false,
            ])
            ->add('orientation', EntityType::class, [
                'class' => Orientation::class,
                'label' => 'Orientación',
                'placeholder' => 'Selecciona Orientación',
                'required' => false,
            ])
            ->add('terrace', CheckboxType::class, [
                'label' => 'Terraza',
                'required' => false,
            ])
            ->add('balcony', CheckboxType::class, [
                'label' => 'Balcón',
                'required' => false,
            ])
            ->add('storage_room', CheckboxType::class, [
                'label' => 'Trastero',
                'required' => false,
            ])
            ->add('direct_garage', CheckboxType::class, [
                'label' => 'Garaje Directo',
                'required' => false,
            ])
            ->add('disabled_access', CheckboxType::class, [
                'label' => 'Acceso Minusválidos',
                'required' => false,
            ])
            ->add('zero_dimension', CheckboxType::class, [
                'label' => 'Cota Cero',
                'required' => false,
            ])
            ->add('elevator', CheckboxType::class, [
                'label' => 'Ascensor',
                'required' => false,
            ])
            ->add('zoneOne', EntityType::class, [
                'label' => 'Zona 1',
                'required' => false,
                'class' => Zone::class,
                'placeholder' => 'Selecciona Zona 1',
            ])
            ->add('zoneTwo', EntityType::class, [
                'label' => 'Zona 2',
                'required' => false,
                'class' => Zone::class,
                'placeholder' => 'Selecciona Zona 2',
            ])
            ->add('zoneThree', EntityType::class, [
                'label' => 'Zona 3',
                'required' => false,
                'class' => Zone::class,
                'placeholder' => 'Selecciona Zona 3',
            ])
            ->add('zone_four', EntityType::class, [
                'label' => 'Zona 4',
                'required' => false,
                'class' => Zone::class,
                'placeholder' => 'Selecciona Zona 4',
            ])
            ->add('commercial', EntityType::class, [
                'required' => true,
                'label' => 'Agente',
                'class' => User::class,
                'placeholder' => 'Selecciona un comercial',
                'query_builder' => function(EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.agency = :agency')
                        ->setParameter('agency', $options['agency'])
                        ;
                }
            ])
            ->add('typeProperty', EntityType::class, [
                'label' => 'Tipo Propiedad',
                'required' => true,
                'class' => TypeProperty::class,
                'placeholder' => 'Selecciona Tipo Propiedad',
            ])
            ->add('bedrooms', EntityType::class, [
                'label' => 'Habitaciones',
                'class' => Bedrooms::class,
                'required' => false,
                'placeholder' => 'Selecciona Habitación',
            ])
            ->add('buildingStructure', EntityType::class, [
                'required' => false,
                'label' => 'Estructura',
                'class' => BuildingStructure::class,
                'placeholder' => 'Selecciona Estructura',
            ])
            ->add('income', MoneyType::class, [
                'label' => 'Ingresos',
                'required' => false,
            ])
            ->add('pets', CheckboxType::class, [
                'label' => 'Mascotas',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'role' => null,
            'agency' => null,
        ]);
    }
}
