<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\NoteClient;
use App\Entity\Offered;
use App\Entity\Property;
use App\Entity\Proposal;
use App\Entity\Visit;
use App\Form\ClientRentType;
use App\Form\ClientSellType;
use App\Form\NoteClientType;
use App\Form\OfferedType;
use App\Form\VisitNewType;
use App\Repository\ClientRepository;
use App\Repository\ProposalRepository;
use App\Repository\VisitRepository;
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
     * @Route("/comprar", name="client_sell_index", methods={"GET"})
     */
    public function sell(ClientRepository $clientRepository): Response
    {
        return $this->render('admin/client/sell.html.twig', [
            'clients' => $clientRepository->findClienteForAgencyAndSell($this->getUser()->getAgency()),
        ]);
    }

    /**
     * @Route("/alquiler", name="client_rent_index", methods={"GET"})
     */
    public function rent(ClientRepository $clientRepository): Response
    {
        return $this->render('admin/client/rent.html.twig', [
            'clients' => $clientRepository->findClienteForAgencyAndRent($this->getUser()->getAgency()),
        ]);
    }

    /**
     * @Route("/visitas/alquiler/{id}", name="client_visit_rent_index", methods={"GET"})
     */
    public function visitRent(Client $client, VisitRepository $visitRepository): Response
    {
        return $this->render('admin/client/visit_rent.html.twig', [
            'client' => $client,
            'visits' => $visitRepository->findBy(['client' => $client]),
        ]);
    }

    /**
     * @Route("/visitas/comprar/{id}", name="client_visit_sell_index", methods={"GET"})
     */
    public function visitSell(Client $client, VisitRepository $visitRepository): Response
    {
        return $this->render('admin/client/visit_sell.html.twig', [
            'client' => $client,
            'visits' => $visitRepository->findBy(['client' => $client]),
        ]);
    }

    /**
     * @Route("/propuestas/comprar/{id}", name="client_proposal_sell_index", methods={"GET"})
     */
    public function proposalSell(Client $client, ProposalRepository $proposalRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('admin/client/proposal.html.twig', [
            'client' => $client,
            'proposals' => $proposalRepository->findBy(['client' => $client])
        ]);
    }

    /**
     * @Route("/propuestas/alquiler/{id}", name="client_proposal_rent_index", methods={"GET"})
     */
    public function proposalRent(Client $client, ProposalRepository $proposalRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('admin/client/proposal.html.twig', [
            'client' => $client,
            'proposals' => $proposalRepository->findBy(['client' => $client])
        ]);
    }

    /**
     * @Route("/new/sell", name="client_sell_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $client->setSellOrRent(true);
        $form = $this->createForm(ClientSellType::class, $client, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_sell_edit', [
                'id' => $client->getId()
            ]);
        }

        return $this->render('admin/client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    public function newSellForm(): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientSellType::class, $client, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);

        return $this->render('admin/client/_new_sell.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/posibles/visitas/comprar/{id}", name="client_possible_sell_visits")
     */
    public function possibleVisits(Request $request, Client $client)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em
            ->getRepository(Property::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.proposals', 'pro')
            ->leftJoin('p.propertyReductions', 'pr')
            ->innerJoin('p.rateHousing', 'rh')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('p.street', 's')
            ->innerJoin('s.zone', 'z')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('r.name = :reason')
            ->addSelect('SUM(pr.price) as sumPropertyReduction')
            ->addSelect('COUNT(pro.contract) as countPropertyContract')
            ->addSelect('COUNT(pro.scriptures) as countPropertyScriptures')
            ->groupBy('p.id')
            ->setParameter('reason', 'Venta')
            ->setParameter('enabled', true)
        ;
        
        if ($client->getTypeProperty()) {
            $queryBuilder
                ->andWhere('p.typeProperty = :typeProperty')
                ->setParameter('typeProperty', $client->getTypeProperty())
                ;
        }

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

        if ($client->getVisits()) {
            $client->getVisits()->first();
        }

        if ($client->getBedrooms()) {
            if ($client->getBedrooms()->getName() === "1 - 2") {
                $queryBuilder
                    ->andWhere('(rh.bedrooms >= :start AND rh.bedrooms <= :end)')
                    ->setParameter('start', 1)
                    ->setParameter('end', 2)
                    ;
            }
            if ($client->getBedrooms()->getName() === "2 - 3") {
                $queryBuilder
                    ->andWhere('rh.bedrooms >= :start AND rh.bedrooms <= :end')
                    ->setParameter('start', 2)
                    ->setParameter('end', 3)
                ;
            }
            if ($client->getBedrooms()->getName() === "+3") {
                $queryBuilder
                    ->andWhere('rh.bedrooms >= :start')
                    ->setParameter('start', 3)
                ;
            }
        }

        if ($client->getZoneOne() && $client->getZoneTwo() && $client->getZoneThree() && $client->getZoneFour()) {
            $queryBuilder
                ->andWhere('z.name = :zoneOne OR z.name = :zoneTwo OR z.name = :zoneThree OR z.name = :zoneFour')
                ->setParameter('zoneOne', $client->getZoneOne()->getName())
                ->setParameter('zoneTwo', $client->getZoneTwo()->getName())
                ->setParameter('zoneThree', $client->getZoneThree()->getName())
                ->setParameter('zoneFour', $client->getZoneFour()->getName())
            ;
        } elseif ($client->getZoneOne() && $client->getZoneTwo() && $client->getZoneThree()) {
            $queryBuilder
                ->andWhere('z.name = :zoneOne OR z.name = :zoneTwo OR z.name = :zoneThree')
                ->setParameter('zoneOne', $client->getZoneOne()->getName())
                ->setParameter('zoneTwo', $client->getZoneTwo()->getName())
                ->setParameter('zoneThree', $client->getZoneThree()->getName())
            ;
        } elseif ($client->getZoneOne() && $client->getZoneTwo()) {
            $queryBuilder
                ->andWhere('z.name = :zoneOne OR z.name = :zoneTwo')
                ->setParameter('zoneOne', $client->getZoneOne()->getName())
                ->setParameter('zoneTwo', $client->getZoneTwo()->getName())
            ;
        } elseif ($client->getZoneOne()) {
            $queryBuilder
                ->andWhere('z.name = :zoneOne')
                ->setParameter('zoneOne', $client->getZoneOne()->getName())
            ;
        }
        //Que precio cojo de referencia?? Si es desde ese precio para abajo o como?

//        if ($client->getZone()) {
//            $queryBuilder
//                ->innerJoin('p.street', 's')
//                ->innerJoin('s.zone', 'z')
//            ;
//            dump($client->getZone()->count());
//            dump($client->getZone()->toArray());
//            foreach ($client->getZone() as $key => $zone) {
//                $queryBuilder
//                    ->orWhere('z.id = :zone'.$key)
//                    ->setParameter('zone'.$key, $zone->getId())
//                    ;
//                dump($zone->getName());
//                foreach ($zone->getStreets() as $street) {
//                    dd($street->getZone()->getName());
//                }
//            }
//        }
//dd('ok');

        $possibleVisits = $queryBuilder->getQuery()->getResult();
        return $this->render('admin/client/possible_visits.html.twig', [
            'client' => $client,
            'possibleVisits' => $possibleVisits
        ]);
    }

    /**
     * @Route("/{id}/comprar", name="client_sell_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Client $client): Response
    {
        $em = $this->getDoctrine()->getManager();
        $visit = new Visit();
        $visit->setClient($client);
        $formVisit = $this->createForm(VisitNewType::class, $visit);
        $formVisit->handleRequest($request);

        if ($formVisit->isSubmitted() && $formVisit->isValid()) {
            $em->persist($visit);
            $em->flush();

            $this->addFlash('success', 'Visita creada correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $client->getId()
            ]);
        }

        $nextCall = $request->get('note_client')['nextCall'];
        $comment = $request->get('note_client')['comment'];
        $date = $request->get('note_client')['created'];

        if ($request->isMethod('POST')) {

            if ($nextCall) {
                $client->setNextCall(new \DateTime($nextCall));
                $em->persist($client);
                $em->flush();
            }

            if ($nextCall == null) {
                $client->setNextCall(null);
                $em->persist($client);
                $em->flush();
            }
            if ($comment) {
                $noteClient = new NoteClient();
                $noteClient->setClient($client);
                $noteClient->setCreated(new \DateTime($date));
                $noteClient->setComment($comment);

                $em->persist($noteClient);
                $em->flush();
            }
        }

        $noteClient = new NoteClient();
        $noteClient->setCreated(new \DateTime());
        $noteClient->setClient($client);
        $formNoteClient = $this->createForm(NoteClientType::class, $noteClient, [
            'nextCall' => $client->getNextCall()
        ]);
        $formNoteClient->handleRequest($request);

        $offered = new Offered();
        $offered->setClient($client);
        $formOffered = $this->createForm(OfferedType::class, $offered);
        $formOffered->handleRequest($request);

        if ($formOffered->isSubmitted() && $formOffered->isValid()) {
            if ($offeredExist = $em->getRepository(Offered::class)->findBy(['client' => $client->getId(), 'charge' => $formOffered->get('charge')->getData()])) {
                $this->addFlash('success', 'Ofrecido ya existe');
                return $this->redirectToRoute($request->attributes->get('_route'), [
                    'id' => $client->getId()
                ]);
            }

            $em->persist($offered);
            $em->flush();

            $this->addFlash('success', 'Ofrecido creado correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $client->getId()
            ]);
        }

        return $this->render('admin/client/show_sell.html.twig', [
            'client' => $client,
            'formVisit' => $formVisit->createView(),
            'formNoteClient' => $formNoteClient->createView(),
            'formOffered' => $formOffered->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editar/comprar", name="client_sell_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientSellType::class, $client, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_sell_show', [
                'id' => $client->getId(),
            ]);
        }

        return $this->render('admin/client/edit_sell.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/comprar", name="client_sell_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_sell_index');
    }

    /**
     * @Route("/{id}/alquiler", name="client_rent_delete", methods={"DELETE"})
     */
    public function deleteRent(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_rent_index');
    }

    /**
     * @Route("/api/autocomplete", name="api_client_autocomplete", methods={"GET"})
     */
    public function autocomplete(ClientRepository $clientRepository, Request $request): Response
    {
        $clients = $clientRepository->findFullNameMobile($request->query->get('query'));
        return $this->json([
            'clients' => $clients
        ], 200, [], ['groups' => ['main']]);
    }



    public function newRentForm(): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientRentType::class, $client, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);

        return $this->render('admin/client/_new_rent.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/alquiler", name="client_rent_show", methods={"GET", "POST"})
     */
    public function showRent(Request $request, Client $client): Response
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


        $nextCall = $request->get('note_client')['nextCall'];
        $comment = $request->get('note_client')['comment'];
        $date = $request->get('note_client')['created'];

        if ($request->isMethod('POST')) {

            if ($nextCall) {
                $client->setNextCall(new \DateTime($nextCall));
                $em->persist($client);
                $em->flush();
            }

            if ($nextCall == null) {
                $client->setNextCall(null);
                $em->persist($client);
                $em->flush();
            }
            if ($comment) {
                $noteClient = new NoteClient();
                $noteClient->setClient($client);
                $noteClient->setCreated(new \DateTime($date));
                $noteClient->setComment($comment);

                $em->persist($noteClient);
                $em->flush();
            }
        }

        $noteClient = new NoteClient();
        $noteClient->setCreated(new \DateTime());
        $noteClient->setClient($client);
        $formNoteClient = $this->createForm(NoteClientType::class, $noteClient, [
            'nextCall' => $client->getNextCall()
        ]);
        $formNoteClient->handleRequest($request);

        /*        if ($formNoteClient->isSubmitted() && $formNoteClient->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($noteClient);
                    $entityManager->flush();

                    $this->addFlash('success', 'Comentario creado correctamente');

                    return $this->redirectToRoute($request->attributes->get('_route'), [
                        'id' => $client->getId()
                    ]);
                }*/

        return $this->render('admin/client/show_rent.html.twig', [
            'client' => $client,
            'formVisit' => $formVisit->createView(),
            'formNoteClient' => $formNoteClient->createView()
        ]);
    }

    /**
     * @Route("/new/rent", name="client_rent_new", methods={"GET","POST"})
     */
    public function newRent(Request $request): Response
    {
        $client = new Client();
        $client->setSellOrRent(false);
        $form = $this->createForm(ClientRentType::class, $client, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_rent_index', [
                'id' => $client->getId()
            ]);
        }

        return $this->render('admin/client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editar/alquiler", name="client_rent_edit", methods={"GET","POST"})
     */
    public function editRent(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientRentType::class, $client, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_rent_show', [
                'id' => $client->getId(),
            ]);
        }

        return $this->render('admin/client/edit_rent.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/posibles/visitas/alquiler/c/{id}", name="client_possible_rent_visits")
     */
    public function possibleRentVisits(Request $request, Client $client)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Property::class);

        $queryBuilder = $em
            ->createQueryBuilder('p')
            ->innerJoin('p.rateHousing', 'rh')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('p.street', 's')
            ->innerJoin('s.zone', 'z')
            ->leftJoin('p.propertyReductions', 'pr')
            ->addSelect('SUM(pr.price) as sumPropertyReduction')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Alquiler')
            ->setParameter('enabled', true)
            ->groupBy('p.id')
        ;


/*        if ($client->getHeating()) {
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

        if ($client->getVisits()) {
            $client->getVisits()->first();
        }
*/

        if ($client->getZoneOne()) {
            $queryBuilder
                ->andWhere('z.name = :zoneOne')
                ->setParameter('zoneOne', $client->getZoneOne()->getName())
            ;

            if ($client->getZoneTwo()) {
                $queryBuilder
                    ->orWhere('z.name = :zoneTwo')
                    ->setParameter('zoneTwo', $client->getZoneTwo()->getName())
                ;
            }

            if ($client->getZoneThree()) {
                $queryBuilder
                    ->orWhere('z.name = :zoneThree')
                    ->setParameter('zoneThree', $client->getZoneThree()->getName())
                ;
            }

            if ($client->getZoneFour()) {
                $queryBuilder
                    ->orWhere('z.name = :zoneFour')
                    ->setParameter('zoneFour', $client->getZoneFour()->getName())
                ;
            }
        }

        if ($client->getBedrooms()) {
            if ($client->getBedrooms()->getName() === "1 - 2") {
                $queryBuilder
                    ->andWhere('(rh.bedrooms >= :start AND rh.bedrooms <= :end)')
                    ->setParameter('start', 1)
                    ->setParameter('end', 2)
                ;
            }
            if ($client->getBedrooms()->getName() === "2 - 3") {
                $queryBuilder
                    ->andWhere('rh.bedrooms >= :start AND rh.bedrooms <= :end')
                    ->setParameter('start', 2)
                    ->setParameter('end', 3)
                ;
            }
            if ($client->getBedrooms()->getName() === "+3") {
                $queryBuilder
                    ->andWhere('rh.bedrooms >= :start')
                    ->setParameter('start', 3)
                ;
            }
        }

        if ($client->getPets()) {
            $queryBuilder
                ->andWhere('rh.pets = :pets')
                ->setParameter('pets', $client->getPets())
            ;
        }

        $possibleVisits = $queryBuilder->getQuery()->getResult();
        return $this->render('admin/client/possible_visits_rent.html.twig', [
            'client' => $client,
            'possibleVisits' => $possibleVisits
        ]);
    }
}
