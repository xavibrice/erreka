<?php

namespace App\Controller;

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
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $em = $this->getDoctrine()->getManager();

        $property = new Property();
        $property->setEnabled(true);
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
    public function rateHousingNewShow(Request $request, Property $property): Response
    {
        $em = $this->getDoctrine()->getManager();

        $rateHousing = new RateHousing();
        $rateHousing->setProperty($property);
        $form = $this->createForm(RateHousingType::class, $rateHousing);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($rateHousing);
            $em->flush();

            $this->addFlash('success', 'Valoración creada correctamente');
            return $this->redirectToRoute('property_rate_housing_new_show', ['id' => $property->getId()]);
        }

        return $this->render('admin/property/rate_housing/rate_housing.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editar/{id}/valoracion", name="property_rate_housing_edit", methods={"GET", "POST"})
     */
    public function rateHousingEdit(Request $request, RateHousing $rateHousing): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RateHousingType::class, $rateHousing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Valoración Editada Correctamente');
        }

        return $this->render('admin/property/edit_rate_housing.html.twig', [
            'form' => $form->createView(),
            'rateHousing' => $rateHousing
        ]);
    }

    /**
     * @Route("/autorizacion/{id}", name="property_authorization", methods={"GET", "POST"})
     * @Route("/encargo/{id}", name="property_charge", methods={"GET", "POST"})
     */
    public function rateAuthorizationCharge(Request $request, Property $property): Response
    {
        $em = $this->getDoctrine()->getManager();

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
                'id' => $property->getId()
            ]);
        }

        $visit = new Visit();
        $visit->setProperty($property);
        $formVisit = $this->createForm(VisitType::class, $visit);
        $formVisit->handleRequest($request);

        if ($formVisit->isSubmitted() && $formVisit->isValid()) {
            $em->persist($visit);
            $em->flush();

            $this->addFlash('success', 'Visita creada correctamente');

            return $this->redirectToRoute($request->attributes->get('_route'), [
                'id' => $property->getId()
            ]);
        }

        return $this->render('admin/property/authorization_charge/authorization_charge.html.twig', [
            'form' => $form->createView(),
            'formVisit' => $formVisit->createView(),
            'property' => $property
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
