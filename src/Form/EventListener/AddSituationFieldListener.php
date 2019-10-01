<?php
namespace App\Form\EventListener;

use App\Entity\Situation;
use App\Entity\Zone;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AddSituationFieldListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    private function addSituationForm($form, $situation = null)
    {
        $formOptions = array(
            'label' => 'Situación',
            'class' => Situation::class,
            'placeholder' => 'Seleciona una situación',
            'mapped' => false,
            'choice_label' => 'name'
        );

        if ($situation) {
            $formOptions['data'] = $situation;
        }
        $form->add('situation', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }
        $accessor = PropertyAccess::createPropertyAccessor();
        $reason = $accessor->getValue($data, 'reason');
        $situation = ($reason) ? $reason->getSituation() : null;
        $this->addSituationForm($form, $situation);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $this->addSituationForm($form);
    }
}