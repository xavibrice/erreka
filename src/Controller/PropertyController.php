<?php

namespace App\Controller;

use App\Entity\Charge;
use App\Entity\Proposal;
use App\Form\ChargeType;
use App\Entity\Images;
use App\Entity\NoteNew;
use App\Entity\Property;
use App\Entity\PropertyReduction;
use App\Entity\RateHousing;
use App\Entity\Visit;
use App\Form\Collection\PropertyReductionType;
use App\Form\NoteNewType;
use App\Form\PropertyType;
use App\Form\ProposalType;
use App\Form\RateHousingType;
use App\Form\VisitType;
use App\Repository\ClientRepository;
use App\Repository\PropertyRepository;
use App\Repository\ProposalRepository;
use App\Repository\VisitRepository;
use App\Service\UploaderHelper;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/noticia")
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="property_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            $properties = $propertyRepository->onlyNoticesAdmin($this->getUser()->getAgency()->getName());
        } else {
            $properties = $propertyRepository->onlyNotices($this->getUser()->getAgency()->getName(), $this->getUser());
        }

        return $this->render('admin/property/property.html.twig', [
            'properties' => $properties,
        ]);
    }

    public function property(): Response
    {
        $property = new Property();
        $property->setCommercial($this->getUser());
        $form = $this->createForm(PropertyType::class, $property, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);

        return $this->render('admin/property/_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nueva", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $lastReference = $em->getRepository(Property::class)->findOneBy([], ['id' => 'desc']);

        if ($lastReference) {
            $newReference = $lastReference->getReference() + 1;
        } else {
            $newReference = 1;
        }

        $property = new Property();
        $property->setCommercial($this->getUser());
        $property->setAgency($this->getUser()->getAgency());
        $property->setEnabled(true);
        $form = $this->createForm(PropertyType::class, $property, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setReference($newReference);
            $em->persist($property);
            $em->flush();

            return $this->redirectToRoute('property_show', [
                'id' => $property->getId()
            ]);
        }

        return $this->render('admin/property/new-property.html.twig', [
            'properties' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/ver", name="property_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Property $property): Response
    {
        $em = $this->getDoctrine()->getManager();

        $nextCall = $request->get('note_new')['nextCall'];
        $note = $request->get('note_new')['note'];
        $date = $request->get('note_new')['notice_date'];

        if ($request->isMethod('POST')){
            if($nextCall) {
                $property->setNextCall(new \DateTime($nextCall));
                $em->persist($property);
                $em->flush();
            }

            if($nextCall == null) {
                $property->setNextCall(null);
                $em->persist($property);
                $em->flush();
            }

            if ($note) {
                $noteNew = new NoteNew();
                $noteNew->setProperty($property);
                $noteNew->setNoticeDate(new \DateTime($date));
                $noteNew->setNote($note);

                $em->persist($noteNew);
                $em->flush();
            }
        }

        $noteProperty = new NoteNew();
        $noteProperty->setProperty($property);
        $form = $this->createForm(NoteNewType::class, $noteProperty, [
            'nextCall' => $property->getNextCall()
        ]);


/*        $noteProperty = new NoteNew();
        $noteProperty->setProperty($property);
        $form = $this->createForm(NoteNewType::class, $noteProperty);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($noteProperty);
            $em->flush();

            $this->addFlash('success', 'Nota creada correctamente');

            return $this->redirectToRoute('property_show', [
                'id' => $property->getId()
            ]);
        }*/

        $propertyReduction = new PropertyReduction();
        $propertyReduction->setProperty($property);
        $formReduction = $this->createForm(PropertyReductionType::class, $propertyReduction);
        $formReduction->handleRequest($request);
        if ($formReduction->isSubmitted() && $formReduction->isValid()) {
            $propertyReduction->setLastPrice($propertyReduction->getLastPrice());
            $em = $this->getDoctrine()->getManager();
            $em->persist($propertyReduction);
            $em->flush();

            $this->addFlash('success', 'Precio creado correctamente');
            return $this->redirectToRoute('property_show', ['id' => $property->getId()]);
        }


        return $this->render('admin/property/show.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
            'formReduction' => $formReduction->createView(),
        ]);
    }

    /**
     * @Route("/nueva/{id}/valoracion", name="property_rate_housing_new_show")
     */
    public function rateHousingNewShow(Request $request, Property $property, UploaderHelper $uploaderHelper): Response
    {
        $em = $this->getDoctrine()->getManager();

        $typeCharges = $em->getRepository(\App\Entity\ChargeType::class)->findAll();

        $rateHousing = new RateHousing();
        $form = $this->createForm(RateHousingType::class, $rateHousing);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get("rate_housing")["image"];

            foreach ($files as $file) {
                $image = new Images();
                $image->setNameImage($uploaderHelper->uploadPropertyImage($file));

                $rateHousing->addImage($image);
            }

            $rateHousing->addProperty($property);
            $em->persist($rateHousing);
            $em->flush();

            $this->addFlash('success', 'Valoración creada correctamente');
            return $this->redirectToRoute('property_rate_housing_new_show', ['id' => $property->getId()]);
        }

        return $this->render('admin/property/rate_housing/rate_housing.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
            'typeCharges' => $typeCharges
        ]);
    }

    /**
     * @Route("/editar/{id}/valoracion", name="property_rate_housing_edit", methods={"GET", "POST"})
     */
    public function rateHousingEdit(Request $request, RateHousing $rateHousing, UploaderHelper $uploaderHelper): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RateHousingType::class, $rateHousing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get("rate_housing")["image"];

            foreach ($files as $file) {
                $image = new Images();
                $image->setNameImage($uploaderHelper->uploadPropertyImage($file));

                $rateHousing->addImage($image);
            }
            $em->flush();

            $this->addFlash('success', 'Valoración Editada Correctamente');

            return $this->redirectToRoute('property_rate_housing_new_show', [
                'id' => $rateHousing->getProperty()->first()->getId()
            ]);
        }

        return $this->render('admin/property/rate_housing/edit_rate_housing.html.twig', [
            'form' => $form->createView(),
            'rateHousing' => $rateHousing
        ]);
    }

    /**
     * @Route("/encargo/{id}/{idChargeType}", name="property_charge", methods={"GET", "POST"})
//     * @Route("/encargo/{id}/{idChargeType}", name="property_charge", methods={"GET", "POST"})
     */
    public function charge(Request $request, Property $property, $idChargeType): Response
    {
        $em = $this->getDoctrine()->getManager();

        $sumPropertyReduction = $em->getRepository(PropertyReduction::class)->sumPropertyReduction($property->getId());

        $chargeType = $em->getRepository(\App\Entity\ChargeType::class)->find($idChargeType);

        $charge = new Charge();
        $formCharge = $this->createForm(ChargeType::class, $charge);
        $formCharge->handleRequest($request);
        if ($formCharge->isSubmitted() && $formCharge->isValid()) {
            $charge->setChargeType($chargeType);
            $charge->setProperty($property);
            $em->persist($charge);
            $em->flush();

            $this->addFlash('success', 'Encargo creado correctamente');

            return $this->redirectToRoute('property_charge', [
                'id' => $property->getId(),
                'idChargeType' => $idChargeType
            ]);
        }


        return $this->render('admin/property/authorization_charge/authorization_charge.html.twig', [
            'formCharge' => $formCharge->createView(),
            'property' => $property,
            'chargeType' => $chargeType,
            'sumPropertyReduction' => $sumPropertyReduction,
        ]);
    }


    /**
     * @Route("/encargo/visitas/{id}/{idChargeType}", name="property_charge_visit", methods={"GET", "POST"})
     */
    public function visits(Request $request, Property $property, $idChargeType, VisitRepository $visitRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $sumPropertyReduction = $em->getRepository(PropertyReduction::class)->sumPropertyReduction($property->getId());

        $visit = new Visit();
        $formVisit = $this->createForm(VisitType::class, $visit);
        $formVisit->handleRequest($request);

        if ($formVisit->isSubmitted() && $formVisit->isValid()) {
            $visit->setProperty($property);
            $visit->setPrice($property->getCharge()->getPrice() - $sumPropertyReduction);
            $em->persist($visit);
            $em->flush();

            $this->addFlash('success', 'Visita creada correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $property->getId(),
                'idChargeType' => $idChargeType
            ]);
        }

        return $this->render('admin/property/visit.html.twig', [
            'property' => $property,
            'visits' => $visitRepository->findBy(['property' => $property]),
            'formVisit' => $formVisit->createView(),
            'sumPropertyReduction' => $sumPropertyReduction
        ]);
    }

    /**
     * @Route("/encargo/rebajas/{id}/{idChargeType}", name="property_charge_reduction", methods={"GET", "POST"})
     */
    public function reduction(Request $request, Property $property, $idChargeType, VisitRepository $visitRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $sumPropertyReduction = $em->getRepository(PropertyReduction::class)->sumPropertyReduction($property->getId());

        $propertyReduction = new PropertyReduction();
        $propertyReduction->setProperty($property);
        $form = $this->createForm(PropertyReductionType::class, $propertyReduction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $propertyReduction->setLastPrice(86000);
            $propertyReduction->setPercentage(5);
            $em->persist($propertyReduction);
            $em->flush();

            $this->addFlash('success', 'Rebaja creada correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $property->getId(),
                'idChargeType' => $idChargeType
            ]);
        }

        return $this->render('admin/property/reduction.html.twig', [
            'property' => $property,
            'visits' => $visitRepository->findBy(['property' => $property]),
            'form' => $form->createView(),
            'sumPropertyReduction' => $sumPropertyReduction,
        ]);
    }

    /**
     * @Route("/encargo/propuestas/{id}/{idChargeType}", name="property_charge_proposal", methods={"GET", "POST"})
     */
    public function proposal(Request $request, Property $property, $idChargeType, ProposalRepository $visitRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $sumPropertyReduction = $em->getRepository(PropertyReduction::class)->sumPropertyReduction($property->getId());

        $proposal = new Proposal();
        $proposal->setProperty($property);
        $formProposal = $this->createForm(ProposalType::class, $proposal);
        $formProposal->handleRequest($request);

        if ($formProposal->isSubmitted() && $formProposal->isValid()) {
            $em->persist($proposal);
            $em->flush();

            $this->addFlash('success', 'Propuesta creada correctamente');
            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $property->getId(),
                'idChargeType' => $idChargeType
            ]);
        }

        return $this->render('admin/property/proposal.html.twig', [
            'property' => $property,
            'visits' => $visitRepository->findBy(['property' => $property]),
            'formProposal' => $formProposal->createView(),
            'sumPropertyReduction' => $sumPropertyReduction,
        ]);
    }


    /**
     * @Route("/encargo/client/{id}/{idChargeType}", name="property_charge_client", methods={"GET", "POST"})
     */
    public function clients(Request $request, Property $property, $idChargeType, ClientRepository $clientRepository): Response
    {




        $queryBuilder = $clientRepository
            ->createQueryBuilder('c')
            ->innerJoin('c.bedrooms', 'b')
        ;

        if ($property->getReason()->getName() === 'Alquiler') {
            $queryBuilder
                ->andWhere('c.sellOrRent = :reason')
                ->setParameter('reason', false);
        }
        if ($property->getReason()->getName() === 'Venta') {
            $queryBuilder
                ->andWhere('c.sellOrRent = :reason')
                ->setParameter('reason', true);
        }

        if ($property->getRateHousing()->getBedrooms()) {
            if ($property->getRateHousing()->getBedrooms() >= 1 && $property->getRateHousing()->getBedrooms() <= 2) {
                $queryBuilder
                    ->andWhere('b.name = :bedrooms12 OR b.name = :bedrooms23')
                    ->setParameter('bedrooms12', "1 - 2")
                    ->setParameter('bedrooms23', "2 - 3")
                ;
            } elseif ($property->getRateHousing()->getBedrooms() >= 2 && $property->getRateHousing()->getBedrooms() <=  3) {
                $queryBuilder
                    ->andWhere('b.name = :bedrooms23 OR b.name = :bedrooms3')
                    ->setParameter('bedrooms23', "2 - 3")
                    ->setParameter('bedrooms3', "+3")
                ;
            } elseif ($property->getRateHousing()->getBedrooms() >= 3) {
                $queryBuilder
                    ->andWhere('b.name = :bedrooms')
                    ->setParameter('bedrooms', "+3")
                ;
            }
        }

        if ($property->getRateHousing()->getElevator()) {
            $queryBuilder
                ->andWhere('c.elevator = :elevator')
                ->setParameter('elevator', $property->getRateHousing()->getElevator())
            ;
        }

        if ($property->getStreet()->getZone()) {
            $queryBuilder
                ->andWhere('c.zoneOne = :zoneOne OR c.zoneTwo = :zoneTwo OR c.zoneThree = :zoneThree OR c.zone_four = :zoneFour')
                ->setParameter('zoneOne', $property->getStreet()->getZone())
                ->setParameter('zoneTwo', $property->getStreet()->getZone())
                ->setParameter('zoneThree', $property->getStreet()->getZone())
                ->setParameter('zoneFour', $property->getStreet()->getZone())
            ;
        }

        $possibleClients = $queryBuilder->getQuery()->getResult();

        return $this->render('admin/property/possible-clients.html.twig', [
            'property' => $property,
            'possibleClients' => $possibleClients
        ]);
    }


    /**
     * @Route("/valoracion/encargo/editar/{id}/{idProperty}", name="property_charge_edit", methods={"GET", "POST"})
     */
    public function editCharge(Request $request, Charge $charge, $idProperty)
    {
        $form = $this->createForm(ChargeType::class, $charge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $charge->getChargeType()->getName() . 'editado correctamente.');

            return $this->redirectToRoute('property_charge', [
                'id' => $idProperty,
                'idChargeType' => $charge->getChargeType()->getId()
            ]);
        }

        return $this->render('admin/property/authorization_charge/edit_authorization_charge.html.twig', [
            'charge' => $charge,
            'form' => $form->createView(),
            'idProperty' => $idProperty
        ]);
    }

    /**
     * @Route("/{id}/editar", name="property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property, [
            'role' => $this->getUser()->getRoles(),
            'agency' => $this->getUser()->getAgency(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Noticia editada correctamente');

            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
            ]);
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/api/autocomplete/property", name="api_property_autocomplete", methods={"GET"})
     */
    public function autocomplete(PropertyRepository $propertyRepository, Request $request): Response
    {
//        $properties = $propertyRepository->findFullStreet($request->query->get('query'));
        $properties = $propertyRepository->findAllMatching($request->query->get('query'));
        return $this->json([
            'properties' => $properties
        ], 200, [], ['groups' => ['main']]);
    }

//
//    /**
//     * @Route("/{id}/show-property-to-developer", name="property_to_developer_show", methods={"GET", "POST"})
//     */
//    public function showPropertyToDeveloper(Request $request, Property $property): Response
//    {
//        $noteProperty = new NoteNew();
//        $noteProperty->setProperty($property);
//        $form = $this->createForm(NoteNewType::class, $noteProperty);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($noteProperty);
//            $em->flush();
//
//            $this->addFlash('success', 'Nota creada correctamente');
//
//            return $this->redirectToRoute('property_to_developer_show', [
//                'id' => $property->getId()
//            ]);
//        }
//
//        return $this->render('admin/property/show-property-to-developer.html.twig', [
//            'property' => $property,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{charge}/{property}", name="charge_for_property", methods={"GET"})
//     */
//    public function chargeForProperty(PropertyRepository $propertyRepository, $charge, $property): Response
//    {
//        $charges = $propertyRepository->chargeForSituation($charge, $property, $this->getUser());
//
//        $typeProperty = $this->getDoctrine()->getRepository(TypeProperty::class)->findBy(['name_slug' => $property]);
//
//        return $this->render('admin/property/charge.html.twig', [
//            'charges' => $charges,
//            'typeProperty' => $typeProperty,
//        ]);
//    }
//
//    public function templateCharge($template, int $idTypeProperty): Response
//    {
//        $property = new Property();
//        $property->setCommercial($this->getUser());
//
//        if ($template === 1) {
//            echo $template;
//        } elseif ($template === 2) {
//            $form = $this->createForm(PropertyChargeTwoType::class, $property, ['idTypeProperty' => $idTypeProperty]);
//        } elseif ($template === 3) {
//            $form = $this->createForm(PropertyChargeThreeType::class, $property, ['idTypeProperty' => $idTypeProperty]);
//        }
//
//        return $this->render('admin/property/template/template'.$template.'.html.twig', [
//            'form' => $form->createView(),
//            'template' => $template,
//            'idTypeProperty' => $idTypeProperty,
//        ]);
//    }


//    /**
//     * @Route("/{id}/edit", name="property_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Property $property): Response
//    {
//        $form = $this->createForm(PropertyType::class, $property);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('property_index', [
//                'id' => $property->getId(),
//            ]);
//        }
//
//        return $this->render('admin/property/edit.html.twig', [
//            'property' => $property,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/{id}", name="property_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Property $property): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($property);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('property_index');
//    }
}
