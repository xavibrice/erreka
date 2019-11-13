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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyChargeTwoType extends AbstractType
{

    private $nameTypeProperty;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->nameTypeProperty = $options['nameTypeProperty'];

        $property = $options['data'] ?? null;
        $isEdit = $property && $property->getId();

        $builder
            ->add('reason', ChoiceType::class, [
                'label' => false,
                'mapped' => false,
                'placeholder' => 'Seleciona Motivo',
                'choices'  => [
                    'Venta' => 'venta',
                    'Alquiler' => 'alquiler',
                ]
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
            ->add('commercial', EntityType::class, [
                'class' => User::class
            ])
            ->add('typeProperty', EntityType::class, [
//                'placeholder' => 'Selecciona un tipo de propiedad',
                'class' => TypeProperty::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('tp')
                        ->where('tp.name = :nameTypeProperty')
                        ->setParameter('nameTypeProperty', $this->nameTypeProperty)
                        ;
                }
            ])
            ->add('zone', EntityType::class, [
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
            'nameTypeProperty' => null
        ]);
    }

}
