<?php

namespace App\Form;

use App\Entity\NoteNew;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteNewNextCallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('next_call', DateTimePickerType::class, [
                'label' => 'Proxima Llamada',
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteNew::class,
        ]);
    }
}
