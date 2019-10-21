<?php

namespace App\Controller;

use App\Entity\NoteNew;
use App\Entity\Property;
use App\Entity\RateHousing;
use App\Entity\TypeProperty;
use App\Form\NoteNewType;
use App\Form\PropertyChargeThreeType;
use App\Form\PropertyChargeTwoType;
use App\Form\PropertyToDeveloperType;
use App\Form\PropertyType;
use App\Form\RateHousingType;
use App\Repository\PropertyRepository;
use App\Repository\SituationRepository;
use App\Repository\TypePropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/property")
 */
class PropertyController extends AbstractController
{

    /**
     * @Route("/{situation}", name="situation_for_property", methods={"GET"})
     */
    public function situationForProperty(PropertyRepository $propertyRepository, $situation): Response
    {
        $properties = $propertyRepository->propertyForSituation($situation, $this->getUser());

        return $this->render('admin/property/'.$situation.'.html.twig', [
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/new-property", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $property->setEnabled(true);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('situation_for_property', [
                'situation' => 'noticia'
            ]);
        }

        return $this->render('admin/property/new-property.html.twig', [
            'properties' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit-property", name="property_edit", methods={"GET","POST"})
     */
    public function editProperty(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('situation_for_property', [
                'situation' => 'noticia',
//                'id' => $property->getId(),
            ]);
        }

        return $this->render('admin/property/edit-property.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    public function property(): Response
    {
        $property = new Property();
        $property->setCommercial($this->getUser());
        $form = $this->createForm(PropertyType::class, $property);

        return $this->render('admin/property/new-property.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new-property-to-developer", name="property_to_developer_new", methods={"GET","POST"})
     */
    public function newPropertyToDeveloper(Request $request): Response
    {
        $property = new Property();
        $property->setEnabled(true);
        $form = $this->createForm(PropertyToDeveloperType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('situation_for_property', [
                'situation' => 'noticia-a-desarrollar'
            ]);
        }

        return $this->render('admin/property/new-property-to-developer.html.twig', [
            'properties' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit-property-to-developer", name="property_to_developer_edit", methods={"GET","POST"})
     */
    public function editPropertyToDeveloper(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyToDeveloperType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('situation_for_property', [
                'situation' => 'noticia-a-desarrollar',
//                'id' => $property->getId(),
            ]);
        }

        return $this->render('admin/property/edit-property-to-developer.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    public function propertyToDeveloper(): Response
    {
        $property = new Property();
        $property->setCommercial($this->getUser());
        $form = $this->createForm(PropertyToDeveloperType::class, $property);

        return $this->render('admin/property/new-property-to-developer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show-property", name="property_show", methods={"GET", "POST"})
     */
    public function showProperty(Request $request, Property $property): Response
    {
        $noteProperty = new NoteNew();
        $noteProperty->setProperty($property);
        $form = $this->createForm(NoteNewType::class, $noteProperty);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noteProperty);
            $em->flush();

            $this->addFlash('success', 'Nota creada correctamente');

            return $this->redirectToRoute('property_show', [
                'id' => $property->getId()
            ]);
        }

        $rateHousing = new RateHousing();
        $rateHousing->setProperty($property);
        $formRate = $this->createForm(RateHousingType::class, $rateHousing);
        $formRate->handleRequest($request);
        if ($formRate->isSubmitted() && $formRate->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rateHousing);
            $entityManager->flush();

            $this->addFlash('success', 'Valoración creada correctamente');
            return $this->redirectToRoute('property_show', ['id' => $property->getId()]);
        }

        return $this->render('admin/property/show-property.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
            'formRate' => $formRate->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show-property-to-developer", name="property_to_developer_show", methods={"GET", "POST"})
     */
    public function showPropertyToDeveloper(Request $request, Property $property): Response
    {
        $noteProperty = new NoteNew();
        $noteProperty->setProperty($property);
        $form = $this->createForm(NoteNewType::class, $noteProperty);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noteProperty);
            $em->flush();

            $this->addFlash('success', 'Nota creada correctamente');

            return $this->redirectToRoute('property_to_developer_show', [
                'id' => $property->getId()
            ]);
        }

        return $this->render('admin/property/show-property-to-developer.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{charge}/{property}", name="charge_for_property", methods={"GET"})
     */
    public function chargeForProperty(PropertyRepository $propertyRepository, $charge, $property): Response
    {
        $charges = $propertyRepository->chargeForSituation($charge, $property, $this->getUser());

        $typeProperty = $this->getDoctrine()->getRepository(TypeProperty::class)->findBy(['name_slug' => $property]);

        return $this->render('admin/property/charge.html.twig', [
            'charges' => $charges,
            'typeProperty' => $typeProperty,
        ]);
    }

    public function templateCharge($template, int $idTypeProperty): Response
    {
        $property = new Property();
        $property->setCommercial($this->getUser());

        if ($template === 1) {
            echo $template;
        } elseif ($template === 2) {
            $form = $this->createForm(PropertyChargeTwoType::class, $property, ['idTypeProperty' => $idTypeProperty]);
        } elseif ($template === 3) {
            $form = $this->createForm(PropertyChargeThreeType::class, $property, ['idTypeProperty' => $idTypeProperty]);
        }

        return $this->render('admin/property/template/template'.$template.'.html.twig', [
            'form' => $form->createView(),
            'template' => $template,
            'idTypeProperty' => $idTypeProperty,
        ]);
    }


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
