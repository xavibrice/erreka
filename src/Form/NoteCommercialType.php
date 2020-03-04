<?php

namespace App\Form;

use App\Entity\NoteCommercial;
use App\Entity\User;
use App\Form\Type\DateTimePickerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteCommercialType extends AbstractType
{
    private $agency;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->agency = $options['agency'];
        $builder
            ->add('note', TextareaType::class, [
                'label' => 'Nota'
            ])
            ->add('notice_date', DateTimePickerType::class, [
                'label' => 'Selecciona Fecha',
                'data' => new \DateTime(),
//                'widget' => 'single_text',
//                'format' => 'dd-MM-yyyy',
//                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('commercial', EntityType::class, [
                'label' => "Selecciona un agente",
                'class' => User::class,
                'placeholder' => "Selecciona un comercial",
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->innerJoin('u.agency', 'a')
                        ->andWhere('a.name = :agency')
                        ->setParameter('agency', $this->agency)
                        ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteCommercial::class,
            'agency' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'appbundle_note_commercial'; // TODO: Change the autogenerated stub
    }
}
