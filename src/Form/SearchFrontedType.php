<?php

namespace App\Form;

use App\Entity\SearchFronted;
use App\Entity\TypeProperty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFrontedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sellOrRent', ChoiceType::class, [
                'label' => 'Compra / Alquiler:',
                'choices' => $this->getChoices(),
                'mapped' => false,
                'placeholder' => 'Selecciona Motivo',
                'attr' => [
                    'class' => 'form-control-lg form-control-a'
                ]
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Dormitorios:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control-lg form-control-a'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio Hasta:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control-lg form-control-a'
                ]
            ])
            ->add('typeProperty', EntityType::class, [
                'label' => 'Tipo Propiedad:',
                'class' => TypeProperty::class,
                'placeholder' => 'Selecciona propiedad',
                'required' => false,
                'attr' => [
                    'class' => 'form-control-lg form-control-a'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchFronted::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    private function getChoices()
    {
        $choices = SearchFronted::SELL_OR_RENT;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }

        return $output;
    }
}
