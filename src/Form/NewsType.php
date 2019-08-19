<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\Owner;
use App\Entity\User;
use App\Entity\Zone;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', MoneyType::class, [
                'label' => 'Precio'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario'
            ])
            ->add('owner', EntityType::class, [
                'label' => 'Propietarios',
                'class' => Owner::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('o')
                        ->orderBy('o.first_name', 'ASC');
                },
                'choice_label' => 'first_name',
                'placeholder' => 'Selecciona propietario',
                'required' => false,
            ])
            ->add('zone', EntityType::class, [
                'label' => 'Zona',
                'class' => Zone::class,
                'placeholder' => 'Selecciona zona',
                'required' => false
            ])
            ->add('commercial', EntityType::class, [
                'label' => 'Comercial',
                'class' => User::class,
                'placeholder' => 'Selecciona un comercial',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }

    public function getBlockPrefix()
    {
//        return parent::getBlockPrefix(); // TODO: Change the autogenerated stub
        return 'appbundle_news';
    }
}
