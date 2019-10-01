<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\News;
use App\Entity\Reason;
use App\Entity\Situation;
use App\Entity\SubCategory;
use App\Entity\User;
use App\Form\EventListener\AddReasonFieldListener;
use App\Form\EventListener\AddSituationFieldListener;
use App\Form\EventListener\AddStreetFieldListener;
use App\Form\EventListener\AddZoneFieldListener;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commercial', EntityType::class, [
                'label' => ' ',
                'class' => User::class,
                'placeholder' => 'Selecciona un comercial',
//                'required' => false
            ])
//            ->addEventSubscriber(new AddZoneFieldListener())
//            ->addEventSubscriber(new AddStreetFieldListener())
//            ->addEventSubscriber(new AddSituationFieldListener())
//            ->addEventSubscriber(new AddReasonFieldListener())
;
            $builder
            ->add('portal', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nº Portal',
                ]
            ])
            ->add('floor', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Piso',
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nombre del propietario',
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Apellidos',
                ]
            ])
            ->add('mobile', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Móvil',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Teléfono',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Correo',
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Precio'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => ' ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Comentario del propietario',
                    'cols' => 100,
                    'rows' => 5
                ]
            ])
        ;

            $builder->add('situation', EntityType::class, [
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
                            'class' => Reason::class,
                            'placeholder' => 'Selecciona una razón',
                            'choices' => $reason->getSituation()->getReason()
                        ]);
                    } else {
                        $form->add('reason', EntityType::class, [
                            'class' => Reason::class,
                            'placeholder' => 'Selecciona una razón',
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
