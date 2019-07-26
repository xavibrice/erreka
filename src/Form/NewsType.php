<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\Owner;
use App\Entity\Zone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('comment')
            ->add('owner', EntityType::class, [
                'class' => Owner::class,
                'placeholder' => 'Selecciona propietario',
                'required' => false
            ])
            ->add('zone', EntityType::class, [
                'class' => Zone::class,
                'placeholder' => 'Selecciona zona',
                'required' => false
            ])
//            ->add('commercial')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
