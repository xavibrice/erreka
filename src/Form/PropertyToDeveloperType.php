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
use App\Form\Type\DatePickerType;
use App\Form\Type\DateTimePickerType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyToDeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = $options['role'];
        $role = implode(',', $roles);

        if ($role === 'ROLE_ADMIN') {
            $builder
                ->add('commercial', EntityType::class, [
                    'label' => 'Agente',
                    'placeholder' => 'Selecciona un agente',
                    'class' => User::class,
                    'query_builder' => function(EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.agency = :agency')
                        ->setParameter('agency', $options['agency'])
                        ;
                    }
                ]);
        }

        $property = $options['data'] ?? null;
        $isEdit = $property && $property->getId();

        $builder->add('zone', EntityType::class, [
            'label' => 'Zona',
            'class' => Zone::class,
            'placeholder' => 'Selecciona una zona',
            'mapped' => false,
            'query_builder' => function(EntityRepository $er) use ($options) {
                return $er->createQueryBuilder('z')
                    ->andWhere('z.agency = :agency')
                    ->setParameter('agency', $options['agency'])
                    ;
            }
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

        if ($isEdit) {
            $builder->add('situation', EntityType::class, [
                'label' => 'Situación',
                'class' => Situation::class,
                'placeholder' => 'Selecciona una situación',
                'mapped' => false,
                'query_builder' => function(EntityRepository $s) {
                    return $s->createQueryBuilder('s')
                        ->andwhere('s.name = :notice or s.name = :noticetodeveloper')
                        ->setParameter('notice', 'noticia')
                        ->setParameter('noticetodeveloper', 'noticia a desarrollar')
                        ;
                }
            ]);

            $builder->get('situation')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event)
                {
                    $form = $event->getForm();
                    $form->getParent()->add('reason', EntityType::class, [
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
            $builder->add('reason', EntityType::class, [
                    'label' => 'Motivo',
                    'placeholder' => 'Selecciona un motivo',
                    'class' => Reason::class,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('r')
                            ->innerJoin('r.situation', 's')
                            ->where('s.name = :situation')
                            ->setParameter('situation', 'noticia a desarrollar')
                            ;
                    }
                ])
            ;
        }

        $builder
            ->add('created', DatePickerType::class, [
                'label' => 'Fecha',
                'required' => true,
                'data' => new \DateTime(),
//                'label' => false,
//                'widget' => 'single_text',
//                'format' => 'dd-MM-yyyy',
//                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('full_name', TextType::class, [
                'label' => 'Propietario',
                'required' => false
            ])
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'required' => false
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Móvil',
                'required' => false
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono',
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo',
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario Noticia',
                'required' => false
            ])
            ->add('portal', TextType::class, [
                'label' => 'Portal',
                'required' => false
            ])
            ->add('floor', TextType::class, [
                'label' => 'Piso',
                'required' => false
            ])
            ->add('typeProperty', EntityType::class, [
                'placeholder' => 'Selecciona un tipo de propiedad',
                'class' => TypeProperty::class,
                'label' => 'Tipo Propiedad'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'role' => null,
            'agency' => null,
        ]);
    }

}
