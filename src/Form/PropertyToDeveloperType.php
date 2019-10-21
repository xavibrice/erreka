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
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
        $property = $options['data'] ?? null;
        $isEdit = $property && $property->getId();

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
            $builder->add('reason', EntityType::class, [
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
                'placeholder' => 'Selecciona un comercial',
                'class' => User::class
            ])
            ->add('created', DateType::class, [
                'required' => true,
//                'label' => false,
                'widget' => 'single_text',
                'format' => 'dd-mm-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('commercial', EntityType::class, [
                'class' => User::class
            ])
            ->add('full_name', TextType::class, [
                'required' => false
            ])
            ->add('mobile', TelType::class, [
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'required' => false
            ])
//            ->add('typeProperty', EntityType::class, [
//                'placeholder' => 'Selecciona un tipo de propiedad',
//                'class' => TypeProperty::class,
//                'query_builder' => function(EntityRepository $er) {
//                    return $er->createQueryBuilder('tp')
//                        ->where('tp.is_property = :property')
//                        ->setParameter('property', false)
//                        ;
//                }
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

}
