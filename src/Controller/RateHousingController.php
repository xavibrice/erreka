<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\RateHousing;
use App\Form\RateHousingType;
use App\Repository\RateHousingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rate/housing")
 */
class RateHousingController extends AbstractController
{
    /**
     * @Route("/", name="rate_housing_index", methods={"GET"})
     */
    public function index(RateHousingRepository $rateHousingRepository): Response
    {
        return $this->render('admin/rate_housing/index.html.twig', [
            'rate_housings' => $rateHousingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rate_housing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rateHousing = new RateHousing();
        $rateHousing->setNew();
        $form = $this->createForm(RateHousingType::class, $rateHousing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rateHousing);
            $entityManager->flush();

            $this->addFlash('success', 'Valoración creada correctamente.');
            return $this->redirectToRoute('rate_housing_index');
        } else {
            $this->addFlash('success', 'Error al crear valoración.');
        }

        return $this->render('admin/rate_housing/new.html.twig', [
            'rate_housing' => $rateHousing,
            'form' => $form->createView(),
        ]);
    }

    public function newForm(): Response
    {
        $rateHousing = new RateHousing();
        $form = $this->createForm(RateHousingType::class, $rateHousing);

        return $this->render('admin/rate_housing/new_form.html.twig', [
            'rate_housing' => $rateHousing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rate_housing_show", methods={"GET"})
     */
    public function show(RateHousing $rateHousing): Response
    {
        return $this->render('admin/rate_housing/show.html.twig', [
            'rate_housing' => $rateHousing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rate_housing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RateHousing $rateHousing): Response
    {
        $form = $this->createForm(RateHousingType::class, $rateHousing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_show', [
                'id' => $rateHousing->getNew()->getId(),
            ]);
        }

        return $this->render('admin/rate_housing/edit.html.twig', [
            'rate_housing' => $rateHousing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rate_housing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RateHousing $rateHousing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rateHousing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rateHousing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rate_housing_index');
    }
}
