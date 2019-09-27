<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\NoteNew;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('notice_date', DateType::class, [
                'label' => 'Selecciona Fecha',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('nextCall', DateType::class, [
                'label' => 'Siguiente Llamada',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('new', EntityType::class, [
                'label' => 'Noticia',
                'class' => News::class,
                'placeholder' => 'Selecciona una noticia'
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Nota para noticia'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteNew::class,
        ]);
    }
}
