<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\NoteCommercialRepository;
use App\Repository\NoteNewRepository;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/alerts/recados", name="alerts_notes", methods={"GET"})
     */
    public function notes(NoteCommercialRepository $noteCommercialRepository): Response
    {
        return $this->render('admin/default/note.html.twig', [
            'note_commercials' => $noteCommercialRepository->findBy(['commercial' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/alerts/notices-to-developer", name="alerts_notices_to_developer", methods={"GET"})
     */
    public function noticestodeveloper(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/default/notices_to_developer.html.twig', [
            'noticestodeveloper' => $propertyRepository->alertsOnlyNoticesToDeveloper($this->getUser())
        ]);
    }

    /**
     * @Route("/alerts/notices", name="alerts_notices", methods={"GET"})
     */
    public function notices(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/default/notices.html.twig', [
            'notices' => $propertyRepository->alertsOnlyNotices($this->getUser(), $this->getUser()->getAgency())
        ]);
    }

    /**
     * @Route("/alerts/charges", name="alerts_charges", methods={"GET"})
     */
    public function charges(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/default/charges.html.twig', [
            'charges' => $propertyRepository->alertsOnlyCharges($this->getUser())
        ]);
    }

    /**
     * @Route("/alerts/clients", name="alerts_clients", methods={"GET"})
     */
    public function clients(ClientRepository $clientRepository): Response
    {
        return $this->render('admin/default/clients.html.twig', [
            'clients' => $clientRepository->alertsOnlyClients($this->getUser())
        ]);
    }
}
