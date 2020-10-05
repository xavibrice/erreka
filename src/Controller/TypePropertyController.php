<?php

namespace App\Controller;

use App\Entity\TypeProperty;
use App\Form\TypePropertyType;
use App\Repository\TypePropertyRepository;
use App\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tipo/propiedad")
 */
class TypePropertyController extends AbstractController
{
    /**
     * @Route("/", name="type_property_index", methods={"GET"})
     */
    public function index(TypePropertyRepository $typePropertyRepository, Request $request): Response
    {
        return $this->render('admin/type_property/index.html.twig', [
            'type_properties' => $typePropertyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_property_new", methods={"GET","POST"})
     */
    public function new(Request $request, Slugger $slugger): Response
    {
        $typeProperty = new TypeProperty();
        $form = $this->createForm(TypePropertyType::class, $typeProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slugify($typeProperty->getName());
            $typeProperty->setNameSlug($slug);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeProperty);
            $entityManager->flush();

            return $this->redirectToRoute('type_property_index');
        }

        return $this->render('admin/type_property/new.html.twig', [
            'type_property' => $typeProperty,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_property_show", methods={"GET"})
     */
    public function show(TypeProperty $typeProperty): Response
    {
        return $this->render('admin/type_property/show.html.twig', [
            'type_property' => $typeProperty,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeProperty $typeProperty, Slugger $slugger): Response
    {
        $form = $this->createForm(TypePropertyType::class, $typeProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slugify($typeProperty->getName());
            $typeProperty->setNameSlug($slug);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_property_index', [
                'id' => $typeProperty->getId(),
            ]);
        }

        return $this->render('admin/type_property/edit.html.twig', [
            'type_property' => $typeProperty,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_property_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeProperty $typeProperty): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeProperty->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeProperty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_property_index');
    }
}
