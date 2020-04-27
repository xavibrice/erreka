<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\NoteCommercialRepository;
use App\Repository\NoteNewRepository;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        return $this->render('fronted/default/index.html.twig');
    }

    /**
     * @Route("/nosotros", name="about_us")
     */
    public function about()
    {
        return $this->render('fronted/default/about.html.twig');
    }

    /**
     * @Route("/alerts/recados", name="alerts_notes", methods={"GET"})
     */
    public function notes(NoteCommercialRepository $noteCommercialRepository): Response
    {
        return $this->render('admin/default/note.html.twig', [
            'note_commercials' => $noteCommercialRepository->findByDate(['commercial' => $this->getUser()]),
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
        //SEPARARLOS POR VENTA Y ALQUILER
        return $this->render('admin/default/clients.html.twig', [
            'clientsSells' => $clientRepository->alertsOnlyClientsSell($this->getUser()),
            'clientsRents' => $clientRepository->alertsOnlyClientsRent($this->getUser())
        ]);
    }

    /**
     * @Route("/buscar", name="search")
     */
    public function search(Request $request, ClientRepository $clientRepository, PropertyRepository $propertyRepository): Response
    {

        $dataSearch = '%' . $request->request->get('search') . '%';

        $clients = $clientRepository->createQueryBuilder('c')
            ->andWhere('c.full_name LIKE :dataFullName OR c.mobile LIKE :dataMobile')
            ->setParameter('dataFullName', $dataSearch)
            ->setParameter('dataMobile', $dataSearch)
            ->getQuery()
            ->getResult()
        ;

        $properties = $propertyRepository->createQueryBuilder('p')
            ->andWhere('p.full_name LIKE :dataFullName OR p.mobile LIKE :dataMobile')
            ->setParameter('dataFullName', $dataSearch)
            ->setParameter('dataMobile', $dataSearch)
            ->getQuery()
            ->getResult()
        ;
        //$properties = $propertyRepository->findBy(['full_name' => $dataSearch]);

        return $this->render('admin/default/search.html.twig', [
            'clients' => $clients,
            'properties' => $properties,
        ]);
    }
}
