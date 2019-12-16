<?php
namespace App\Controller;

use App\Entity\NoteNew;
use App\Entity\Property;
use App\Form\NoteNewType;
use App\Form\PropertyToDeveloperType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/noticia-a-desarrollar")
 */
class PropertyToDeveloperController extends AbstractController
{

    /**
     * @Route("/", name="property_to_developer_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        $propierties = $propertyRepository->onlyNoticesToDeveloper($this->getUser());

        return $this->render('admin/property_to_developer/property-to-developer.html.twig', [
            'properties' => $propierties
        ]);
    }

    /**
     * @Route("/{id}/ver", name="property_to_developer_show", methods={"GET", "POST"})
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

            return $this->redirectToRoute('property_to_developer_show', [
                'id' => $property->getId()
            ]);
        }

        return $this->render('admin/property_to_developer/show-property-to-developer.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    public function propertyToDeveloper(): Response
    {
        $property = new Property();
        $property->setCommercial($this->getUser());
        $form = $this->createForm(PropertyToDeveloperType::class, $property);

        return $this->render('admin/property_to_developer/new-property-to-developer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nueva", name="property_to_developer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $property->setEnabled(true);
        $form = $this->createForm(PropertyToDeveloperType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('property_to_developer_show', [
                'id' => $property->getId()
            ]);
        }

        return $this->render('admin/property_to_developer/new-property-to-developer.html.twig', [
            'properties' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editar-property-to-developer", name="property_to_developer_edit", methods={"GET","POST"})
     */
    public function editPropertyToDeveloper(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyToDeveloperType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Noticia a desarrollar editada correctamente');
            return $this->redirectToRoute('property_to_developer_edit', [
                'id' => $property->getId()
            ]);
        }

        return $this->render('admin/property_to_developer/edit-property-to-developer.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }
}