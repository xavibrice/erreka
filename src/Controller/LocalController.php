<?php

namespace App\Controller;

use App\Entity\NoteNew;
use App\Entity\Property;
use App\Entity\RateHousing;
use App\Entity\Reason;
use App\Entity\StateProperty;
use App\Entity\TypeProperty;
use App\Form\NoteNewType;
use App\Form\PropertyChargeTwoType;
use App\Form\RateHousingType;
use App\Form\ReasonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/local")
 */
class LocalController extends AbstractController
{
    /**
     * @Route("/", name="local_index", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $state = $em->getRepository(StateProperty::class)->findOneBy(['name' => 'exclusiva']);

        $property = new Property();
        $property->setStateProperty($state);
        $form = $this->createForm(PropertyChargeTwoType::class, $property, ['nameTypeProperty' => 'local']);
        $form->handleRequest($request);
        $reason = $em->getRepository(Reason::class)->findOneBy(['name' => $form->get('reason')->getData()]);
        $property->setReason($reason);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($property);
            $em->flush();

            $this->addFlash('success', 'Local creado correctamente');

            return  $this->redirectToRoute('local_show', [
                'id' => $property->getId()
            ]);
        }

        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('local', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/local/index.html.twig', [
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="local_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Property $property): Response
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

            return $this->redirectToRoute('local_show', [
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
            return $this->redirectToRoute('local_show', ['id' => $property->getId()]);
        }

        return $this->render('charge/local/show.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
            'formRate' => $formRate->createView()
        ]);
    }

    /**
     * @Route("/{id}/editar-local", name="local_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Property $property): Response
    {

    }


}
