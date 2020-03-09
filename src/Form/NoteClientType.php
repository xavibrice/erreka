<?php

namespace App\Form;

use App\Entity\NoteClient;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $nextCall = $options['nextCall'];

        $builder
            ->add('created', DatePickerType::class, [
                'label' => 'Fecha creación',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
            ->add('nextCall', DatePickerType::class, [
                'required' => false,
                'mapped' => false,
                'data' => $nextCall,
                'label' => 'Próxima Llamada',
                'attr' => [
                    'class' => 'js-datepicker-empty',
                ]
            ])
//            ->add('created')
//            ->add('client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteClient::class,
            'nextCall' => null,
        ]);
    }
}
