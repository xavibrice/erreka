<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\RateHousing;
use App\Entity\Reason;
use App\Entity\Situation;
use App\Entity\Street;
use App\Entity\User;
use App\Entity\Zone;
use App\Form\Collection\NewsNoteNewType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsToDevelopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var News|null $new */
        $new = $options['data'] ?? null;
        $isEdit = $new && $new->getId();

        if ($isEdit) {
            $builder->add('situation', EntityType::class, [
                'label' => false,
                'class' => Situation::class,
                'placeholder' => 'Selecciona una situación',
                'mapped' => false
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
                            'label' => false,
                            'required' => true,
                            'class' => Reason::class,
                            'placeholder' => 'Selecciona primero una situación',
                            'choices' => $reason->getSituation()->getReason()
                        ]);
                    } else {
                        $form->add('reason', EntityType::class, [
                            'label' => false,
                            'required' => true,
                            'class' => Reason::class,
                            'placeholder' => 'Selecciona primero una situación',
                            'choices' => []
                        ]);
                    }
                }
            );
        } else {
            $builder
                ->add('reason', EntityType::class, [
                    'label' => false,
                    'class' => Reason::class,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('r')
                            ->innerJoin('r.situation', 's')
                            ->where('s.name_slug = :situation_name_slug')
                            ->setParameter('situation_name_slug', 'noticia-a-desarrollar')
                            ;
                    }
                ])
            ;
        }

        $builder
            ->add('commercial', EntityType::class, [
                'label' => false,
                'class' => User::class,
                'placeholder' => 'Selecciona un comercial',
            ])
            ->add('created', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'format' => 'dd-mm-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('state', CheckboxType::class, [
                'label' => 'Histórico',
                'required' => false,
                'data' => true
                ])
            ->add('portal', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nº Portal',
                ]
            ])
            ->add('floor', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Piso',
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nombre del propietario',
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Apellidos',
                ]
            ])
            ->add('mobile', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Móvil',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Teléfono',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Correo',
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Comentario del propietario',
                    'cols' => 100,
                    'rows' => 5
                ]
            ])
        ;



            $builder->add('zone', EntityType::class, [
                'label' => false,
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
                            'label' => false,
                            'required' => true,
                            'class' => Street::class,
                            'placeholder' => 'Selecciona primero una zona',
                            'choices' => $street->getZone()->getStreets()
                        ]);
                    } else {
                        $form->add('street', EntityType::class, [
                            'label' => false,
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
            'data_class' => News::class,
        ]);
    }

    public function getParent()
    {
        return parent::getParent(); // TODO: Change the autogenerated stub
    }

    public function getBlockPrefix()
    {
//        return parent::getBlockPrefix(); // TODO: Change the autogenerated stub
        return 'app_news';
    }
}
