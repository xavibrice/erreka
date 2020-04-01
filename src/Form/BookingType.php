<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\LocationBooking;
use App\Entity\TitleBooking;
use App\Entity\User;
use App\Form\Type\DateTimePickerType;
use Cassandra\Date;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    private $agency;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->agency = $options['agency'];
        $builder
            ->add('beginAt', DateTimePickerType::class, [
//                'required' => true,
                'label' => 'Fecha inicio',
//                'disabled' => true,
//                'widget' => 'single_text',
//                'html5' => false,
//                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'dateStart'
                ]
            ])
            ->add('endAt', DateTimePickerType::class, [
                'required' => false,
//                'disabled' => true,
                'label' => 'Fecha fín',
                'attr' => [
                    'class' => 'dateStart'
                ]
            ])
            ->add('titleBooking', EntityType::class, [
                'label' => 'Título',
                'class' => TitleBooking::class,
                'placeholder' => 'Selecciona título',
            ])
            ->add('locationBooking', EntityType::class, [
                'label' => 'Ubicación',
                'class' => LocationBooking::class,
                'placeholder' => 'Selecciona ubicación',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción'
            ])
            ->add('commercial', EntityType::class, [
                'label' => "Selecciona agente",
                'class' => User::class,
                'placeholder' => "Selecciona agente",
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->innerJoin('u.agency', 'a')
                        ->andWhere('a.name = :agency')
                        ->setParameter('agency', $this->agency)
                        ;
                }
            ])
//            ->add('commercial', CommercialSelectType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'agency' => null
        ]);
    }
}
