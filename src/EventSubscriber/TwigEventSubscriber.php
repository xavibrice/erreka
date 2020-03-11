<?php

namespace App\EventSubscriber;

use App\Repository\AgencyRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $agencyRepository;

    public function __construct(Environment $twig, AgencyRepository $agencyRepository)
    {
        $this->twig = $twig;
        $this->agencyRepository = $agencyRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('agencies', $this->agencyRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
