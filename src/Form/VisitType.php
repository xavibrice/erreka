<?php

namespace App\Form;

use App\Controller\ClienteSelectType;
use App\Entity\Client;
use App\Entity\Property;
use App\Entity\Visit;
use App\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visited', DateTimePickerType::class, [
                'required' => true,
                'label' => 'Fecha Visita',
                'data' => new \DateTime(),
//                'widget' => 'single_text',
//                'format' => 'dd-MM-yyyy',
//                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
            ->add('client', ClientSelectType::class, [
                'label' => 'Cliente'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
