<?php

namespace App\Form;

use App\Entity\NoteNew;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $nextCall = $options['nextCall'];


        $builder
            ->add('notice_date', DatePickerType::class, [
                'label' => 'Fecha creación',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Nota',
                'required' => false
            ])
            ->add('nextCall', DatePickerType::class, [
                'required' => false,
                'mapped' => false,
                'data' => $nextCall,
                'label' => 'Próxima Llamada',
                'attr' => [
                    'class' => 'js-datepicker-empty',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteNew::class,
            'nextCall' => null
        ]);
    }
}
