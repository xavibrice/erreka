<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Reason;
use App\Entity\Situation;
use App\Entity\Street;
use App\Entity\TypeProperty;
use App\Entity\User;
use App\Entity\Zone;
use App\Form\Collection\PropertyReductionType;
use App\Form\Type\DateTimePickerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class PropertyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = $options['role'];
        $role = implode(',', $roles);

        if ($role == 'ROLE_ADMIN') {
            $builder
                ->add('commercial', EntityType::class, [
                    'label' => 'Comercial',
                    'class' => User::class,
                ]);

        }
        $property = $options['data'] ?? null;
        $isEdit = $property && $property->getId();

        if ($isEdit) {
            $date = 'js-datepicker-empty';
            /*$builder->add('propertyReductions', CollectionType::class, [
                'label' => 'Rebajar Precio',
                'entry_type' => PropertyReductionType::class,
                'entry_options' => [
                    'label' => true
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ]);*/

            if (!$property->getRateHousing()) {
                $builder->add('situation', EntityType::class, [
                    'label' => 'Situación',
                    'class' => Situation::class,
                    'placeholder' => 'Selecciona una situación',
                    'mapped' => false,
                    'query_builder' => function(EntityRepository $s) {
                        return $s->createQueryBuilder('s')
                            ->where('s.name <> :name')
                            ->setParameter('name', 'noticia a desarrollar')
                            ;
                    }
                ]);
            } else {
                $builder->add('situation', EntityType::class, [
                    'label' => 'Situación',
                    'class' => Situation::class,
                    'placeholder' => 'Selecciona una situación',
                    'mapped' => false,
                    'query_builder' => function(EntityRepository $s) {
                        return $s->createQueryBuilder('s')
                            ->where('s.name != :name')
                            ->setParameter('name', 'noticia a desarrollar')
                            ;
                    }
                ]);
            }

            $builder->get('situation')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event)
                {
                    $form = $event->getForm();
                    $form->getParent()->add('reason', EntityType::class, [
                        'label' => 'Motivo',
                        'class' => Reason::class,
                        'placeholder' => 'Selecciona una razón',
                        'choices' => $form->getData()->getReason()
                    ]);
                }
            );

            $builder->addEventListener(
                FormEvents::POST_SET_DATA,
                function (FormEvent $event)
                {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $reason = $data->getReason();
                    if ($reason) {
                        $form->get('situation')->setData($reason->getSituation());
                        $form->add('reason', EntityType::class, [
                            'label' => 'Motivo',
                            'required' => true,
                            'class' => Reason::class,
                            'placeholder' => 'Selecciona primero una situación',
                            'choices' => $reason->getSituation()->getReason()
                        ]);
                    } else {
                        $form->add('reason', EntityType::class, [
                            'label' => 'Motivo',
                            'required' => true,
                            'class' => Reason::class,
                            'placeholder' => 'Selecciona primero una situación',
                            'choices' => []
                        ]);
                    }
                }
            );
        } else {
            $date = 'js-datepicker';
            $builder->add('reason', EntityType::class, [
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
            ;
        }

        $builder
            ->add('image', FileType::class, [
                'label' => 'Subir fotos',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'attr' => [
                    'accept' => 'image/*'
                ]
            ])
            ->add('created', DateTimePickerType::class, [
                'required' => true,
                'label' => 'Fecha creación',
//                'widget' => 'single_text',
//                'format' => 'dd-MM-yyyy',
//                'html5' => false,
                'data' => new \DateTime(),
                'attr' => [
                    'class' => $date,
                ],
            ])
            ->add('fullName', TextType::class, [
                'label' => 'Propietario',
                'required' => false,
            ])
            ->add('portal', TextType::class, [
                'label' => 'Portal',
                'required' => false
            ])
            ->add('floor', TextType::class, [
                'label' => 'Piso',
                'required' => false
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Móvil',
                'required' => false
            ])
//            ->add('reference', null, [
//                'required' => false,
//                'disabled' => true,
//            ])
//            ->add('email', EmailType::class, [
//                'label' => 'Correo',
//                'required' => false
//            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'required' => false,
            ])
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'required' => false
            ])
            ->add('typeProperty', EntityType::class, [
                'label' => 'Tipo de propiedad',
                'placeholder' => 'Selecciona Tipo Propiedad',
                'class' => TypeProperty::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('tp')
                        ->where('tp.is_property = :property')
                        ->setParameter('property', true)
                        ;
                }
            ])
//            ->add('stateProperty')
//            ->add('visits')
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
            'role' => null
        ]);
    }

}
