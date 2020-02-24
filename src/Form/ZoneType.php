<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Zone;
use App\Form\Collection\StreetZoneType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Zona'
            ])
            ->add('streets', CollectionType::class, [
                'label' => ' ',
                'entry_type' => StreetZoneType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('agency', EntityType::class, [
                'label' => 'Agencia',
                'placeholder' => 'Selecciona una agencia',
                'class' => Agency::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Zone::class,
        ]);
    }

    public function getBlockPrefix()
    {
//        return parent::getBlockPrefix(); // TODO: Change the autogenerated stub
        return 'appbundle_zone';
    }
}
