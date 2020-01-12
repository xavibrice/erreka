<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Reason;
use App\Entity\Street;
use App\Entity\TypeProperty;
use App\Entity\User;
use App\Entity\Zone;
use App\Form\Type\DatePickerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created', DatePickerType::class, [
                'required' => true,
                'label' => 'Fecha creación',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('commercial', EntityType::class, [
                'label' => 'Comercial',
                'class' => User::class,
            ])
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
            ->add('typeProperty', EntityType::class, [
                'label' => 'Tipo de propiedad',
//                'placeholder' => 'Selecciona Tipo Propiedad',
                'disabled' => true,
                'class' => TypeProperty::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('tp')
                        ->where('tp.is_property = :property')
                        ->andWhere('tp.name = :nameProperty')
                        ->setParameter('property', false)
                        ->setParameter('nameProperty', 'local')
                        ;
                }
            ])
            ->add('street')
            ->add('portal', TextType::class, [
                'label' => 'Portal',
                'required' => false
            ])
            ->add('floor', TextType::class, [
                'label' => 'Piso',
                'required' => false
            ])
            ->add('price')
            ->add('fullName', TextType::class, [
                'label' => 'Propietario',
                'required' => false,
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Móvil',
                'required' => false
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono',
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'required' => false
            ])
/*            ->add('rateHousing', CollectionType::class, [
                'label' => ' ',
                'entry_type' => RateHousingLocalType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])*/
        ;


        $builder->add('zone', EntityType::class, [
            'label' => 'Zona',
            'class' => Zone::class,
            'placeholder' => 'Selecciona una zona',
            'mapped' => false
        ]);

        $builder->get('zone')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                $form->getParent()->add('street', EntityType::class, [
                    'label' => 'Calle',
                    'class' => Street::class,
                    'placeholder' => 'Selecciona una calle',
                    'choices' => $form->getData()->getStreets()
                ]);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                $data = $event->getData();
                $street = $data->getStreet();
                if ($street) {
                    $form->get('zone')->setData($street->getZone());
                    $form->add('street', EntityType::class, [
                        'label' => 'Calle',
                        'required' => true,
                        'class' => Street::class,
                        'placeholder' => 'Selecciona primero una zona',
                        'choices' => $street->getZone()->getStreets()
                    ]);
                } else {
                    $form->add('street', EntityType::class, [
                        'label' => 'Calle',
                        'required' => true,
                        'class' => Street::class,
                        'placeholder' => 'Selecciona primero una zona',
                        'choices' => []
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
