<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Property;
use App\Entity\Proposal;
use App\Form\Type\DatePickerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProposalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created', DatePickerType::class, [
                'label' => 'Fecha propuesta',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
/*            ->add('client', ClientSelectType::class, [
                'label' => 'Cliente'
            ])   */
            ->add('client', EntityType::class, [
                'label' => 'Cliente',
                'class' => Client::class,
                'query_builder' => function(EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.sellOrRent = :sellOrRent')
                        ->setParameter('sellOrRent', $options['sellOrRent'])
                        ->orderBy('c.full_name', 'ASC');
                },
                'placeholder' => 'Selecciona cliente'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio'
            ])
            ->add('agree', CheckboxType::class, [
                'label' => '¿Propuesta aceptada?',
                'required' => false
            ])
/*            ->add('contract', DatePickerType::class, [
                'label' => 'Fecha contrato',
                'required' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
            ->add('scriptures', DatePickerType::class, [
                'label' => 'Fecha escrituras',
                'required' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposal::class,
            'sellOrRent' => null,
         ]);
    }
}
