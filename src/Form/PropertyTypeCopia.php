<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Reason;
use App\Entity\Situation;
use App\Entity\Street;
use App\Entity\User;
use App\Entity\Zone;
use App\Form\Collection\PropertyReductionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyTypeCopia extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commercial', EntityType::class, [
                'class' => User::class
            ])
            ->add('enabled', ChoiceType::class, [
                'placeholder' => '¿Propiedad Disponible|Habilitada?',
                'choices' => [
                    'Si' => true,
                    'No' => false,
                ],
                'empty_data' => true
            ])
            ->add('full_name')
            ->add('mobile')
            ->add('email')
            ->add('price')
            ->add('propertyReductions', CollectionType::class, [
                'label' => 'Rebajar Precio',
                'entry_type' => PropertyReductionType::class,
                'entry_options' => [
                    'label' => true
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('typeProperty')
            ->add('stateProperty')
            ->add('visits')
        ;
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
            'data_class' => Property::class,
            'type' => null
        ]);
    }

}
