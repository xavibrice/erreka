<?php


namespace App\Form\EventListener;


use App\Entity\Reason;
use App\Entity\Street;
use App\Entity\Zone;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AddReasonFieldListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    private function addReasonForm($form, $situation_id = null)
    {
        $formOptions = [
            'label' => 'Razón',
            'class' => Reason::class,
            'query_builder' => function (EntityRepository $repository) use ($situation_id) {
            return $repository
                ->createQueryBuilder('r')
                ->where('r.situation = :situation')
                ->setParameter('situation', $situation_id)
                ;
            },
            'mapped' => false,
            'choice_label' => 'name',
            'placeholder' => 'Selecciona primero una situación'
        ];

        $form->add('reason', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        $reason = $accessor->getValue($data, 'reason');
        $situation_id = ($reason) ? $reason->getId() : null;

        $this->addReasonForm($form, $situation_id);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        $situation_id = array_key_exists('situation', $data) ? $data['situation'] : null;
        $this->addReasonForm($form, $situation_id);
    }

}