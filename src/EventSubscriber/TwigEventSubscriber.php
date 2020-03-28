<?php

namespace App\EventSubscriber;

use App\Repository\AgencyRepository;
use App\Repository\ClientStatusRepository;
use App\Repository\SituationRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $agencyRepository;
    private $situationRepository;
    private $clientStatusRepository;

    public function __construct(Environment $twig, AgencyRepository $agencyRepository, SituationRepository $situationRepository, ClientStatusRepository $clientStatusRepository)
    {
        $this->twig = $twig;
        $this->agencyRepository = $agencyRepository;
        $this->situationRepository = $situationRepository;
        $this->clientStatusRepository = $clientStatusRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('agencies', $this->agencyRepository->findAll());
        $this->twig->addGlobal('situations', $this->situationRepository->findBy(['name' => 'Histórico']));
        $this->twig->addGlobal('clientStatus', $this->clientStatusRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
