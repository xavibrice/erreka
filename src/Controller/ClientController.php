<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Property;
use App\Entity\RateHousing;
use App\Entity\Visit;
use App\Form\ClientType;
use App\Form\VisitNewType;
use App\Form\VisitType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cliente")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('admin/client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('admin/client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    public function newForm(): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        return $this->render('admin/client/_new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/posibles/visitas/{id}", name="client_possible_visits")
     */
    public function possibleVisits(Request $request, Client $client)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em
            ->getRepository(Property::class)
            ->createQueryBuilder('p')
            ->innerJoin('p.rateHousing', 'rh')
            ->innerJoin('p.charge', 'c')  
            ->where('p.enabled = :enabled')
            ->setParameter('enabled', true)
        ;

        if ($client->getHeating()) {
            $queryBuilder
                ->innerJoin('rh.heating', 'h')
                ->andWhere('h.name = :heating')
                ->setParameter('heating', $client->getHeating()->getName())
            ;
        }

        if ($client->getOrientation()) {
            $queryBuilder
                ->innerJoin('rh.orientation', 'o')
                ->andWhere('o.name = :orientation')
                ->setParameter('orientation', $client->getOrientation()->getName())
                ;
        }

        if ($client->getElevator()) {
            $queryBuilder
                ->andWhere('rh.elevator = :elevator')
                ->setParameter('elevator', $client->getElevator())
            ;
        }

        if ($client->getBuildingStructure()) {
            $queryBuilder
                ->innerJoin('rh.buildingStructure', 'bs')
                ->andWhere('bs.name = :buildingStructure')
                ->setParameter('buildingStructure', $client->getBuildingStructure()->getName())
            ;
        }

        if ($client->getBalcony()) {
            $queryBuilder
                ->andWhere('rh.balcony = :balcony')
                ->setParameter('balcony', $client->getBalcony())
            ;
        }

        if ($client->getStorageRoom()) {
            $queryBuilder
                ->andWhere('rh.storage_room = :storage_room')
                ->setParameter('storage_room', $client->getStorageRoom())
            ;
        }

        if ($client->getDirectGarage()) {
            $queryBuilder
                ->andWhere('rh.direct_garage = :direct_garage')
                ->setParameter('direct_garage', $client->getDirectGarage())
            ;
        }

        if ($client->getZeroDimension()) {
            $queryBuilder
                ->andWhere('rh.zero_dimension = :zero_dimension')
                ->setParameter('zero_dimension', $client->getZeroDimension())
            ;
        }

        if ($client->getDisabledAccess()) {
            $queryBuilder
                ->andWhere('rh.disabled_access = :disabled_access')
                ->setParameter('disabled_access', $client->getDisabledAccess())
            ;
        }

        if ($client->getPets()) {
            $queryBuilder
                ->andWhere('rh.pets = :pets')
                ->setParameter('pets', $client->getPets())
            ;
        }

        //Que precio cojo de referencia?? Si es desde ese precio para abajo o como?

/*        if ($client->getZone()) {
//            dd($client->getZone()->count());
//            dump($client->getZone()->toArray());
            foreach ($client->getZone() as $zone) {
                dump($zone->getId());
//                foreach ($zone->getStreets() as $street) {
//                    dd($street->getZone()->getName());
//                }
            }
        }
dd('ok');*/

        $possibleVisits = $queryBuilder->getQuery()->getResult();
        return $this->render('admin/client/possible-visits.html.twig', [
            'client' => $client,
            'possibleVisits' => $possibleVisits
        ]);
    }


    /**
     * @Route("/{id}", name="client_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Client $client): Response
    {
        $em = $this->getDoctrine()->getManager();
        $visit = new Visit();
        $visit->setClient($client);
        $formVisit = $this->createForm(VisitNewType::class, $visit);
        $formVisit->handleRequest($request);

        if ($formVisit->isSubmitted() && $formVisit->isValid()) {
//            $client->setPrice(1000);
            $em->persist($visit);
            $em->flush();

            $this->addFlash('success', 'Visita creada correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $client->getId()
            ]);
        }

        return $this->render('admin/client/show.html.twig', [
            'client' => $client,
            'formVisit' => $formVisit->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_show', [
                'id' => $client->getId(),
            ]);
        }

        return $this->render('admin/client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * @Route("/api/autocomplete", name="api_client_autocomplete", methods={"GET"})
     */
    public function autocomplete(ClientRepository $clientRepository, Request $request): Response
    {
//        $clients = $clientRepository->findFullName();
        $clients = $clientRepository->findAllMatching($request->query->get('query'));
        return $this->json([
            'clients' => $clients
        ], 200, [], ['groups' => ['main']]);
    }
}
