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
        $formOptions = [
            'label' => ' ',
            'class' => Situation::class,
            'placeholder' => 'Selecciona situación'
        ];

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
        $situation = $accessor->getValue($data, 'situation');
        $reason = ($situation) ? $situation->getReasons() : null;
        $this->addSituationForm($form, $reason);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $this->addSituationForm($form);
    }


/*    private function addZoneForm($form, $zone = null)
    {
        $formOptions = [
            'class' => Zone::class,
            'placeholder' => 'Selecciona una zona',
            'mapped' => false,
            'choice_label' => 'name'
        ];

        if ($zone) {
            $formOptions['data'] = $zone;
        }

        $form->add('zone', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        $zone = $accessor->getValue($data, 'zone');
        $street = ($zone) ? $zone->getZone() : null;
        $this->addZoneForm($form, $street);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $this->addZoneForm($form);

    }*/

}