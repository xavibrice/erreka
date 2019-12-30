<?php

namespace App\Controller;

use App\Entity\Charge;
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
use App\Form\RateHousingType;
use App\Form\VisitType;
use App\Repository\PropertyRepository;
use App\Service\UploaderHelper;
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
        $properties = $propertyRepository->onlyNotices($this->getUser());

        return $this->render('admin/property/property.html.twig', [
            'properties' => $properties,
        ]);
    }

    public function property(): Response
    {
        $property = new Property();
        $property->setCommercial($this->getUser());
        $form = $this->createForm(PropertyType::class, $property, [
            'role' => $this->getUser()->getRoles()
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
        $property->setEnabled(true);
        $form = $this->createForm(PropertyType::class, $property, [
            'role' => $this->getUser()->getRoles()
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

        $noteProperty = new NoteNew();
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
        }

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
            $charge->addRateHousing($property->getRateHousing());
            $em->persist($charge);
            $em->flush();

            $this->addFlash('success', 'Encargo creado correctamente');

            return $this->redirectToRoute('property_charge', [
                'id' => $property->getId(),
                'idChargeType' => $idChargeType
            ]);
        }

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

        $visit = new Visit();
        $visit->setProperty($property);
        $formVisit = $this->createForm(VisitType::class, $visit);
        $formVisit->handleRequest($request);


        if ($formVisit->isSubmitted() && $formVisit->isValid()) {
            $visit->setPrice($property->getRateHousing()->getCharge()->getPrice() - $sumPropertyReduction);
            $em->persist($visit);
            $em->flush();

            $this->addFlash('success', 'Visita creada correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $property->getId(),
                'idChargeType' => $idChargeType
            ]);
        }

        return $this->render('admin/property/authorization_charge/authorization_charge.html.twig', [
            'form' => $form->createView(),
            'formVisit' => $formVisit->createView(),
            'formCharge' => $formCharge->createView(),
            'property' => $property,
            'chargeType' => $chargeType
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

            return $this->redirectToRoute('property_charge_edit', [
                'id' => $charge->getId(),
                'idProperty' => $idProperty
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
    public function edit(Request $request, Property $property, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(PropertyType::class, $property, [
            'role' => $this->getUser()->getRoles()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get("property")["image"];

            foreach ($files as $file) {
                $image = new Images();
                $image->setNameImage($uploaderHelper->uploadPropertyImage($file));

                $property->addImage($image);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
            ]);
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
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
