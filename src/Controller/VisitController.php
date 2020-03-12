<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\VisitType;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/visitas")
 */
class VisitController extends AbstractController
{
    /**
     * @Route("/comprar", name="visit_sell_index", methods={"GET"})
     */
    public function indexSell(VisitRepository $visitRepository): Response
    {
        return $this->render('admin/visit/index_sell.html.twig', [
            'visits' => $visitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/alquiler", name="visit_rent_index", methods={"GET"})
     */
    public function indexRent(VisitRepository $visitRepository): Response
    {
        return $this->render('admin/visit/index_rent.html.twig', [
            'visits' => $visitRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="visit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $visit = new Visit();
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($visit);
            $entityManager->flush();

            return $this->redirectToRoute('visit_index');
        }

        return $this->render('admin/visit/new.html.twig', [
            'visit' => $visit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="visit_show", methods={"GET"})
     */
    public function show(Visit $visit): Response
    {
        return $this->render('admin/visit/show.html.twig', [
            'visit' => $visit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="visit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Visit $visit): Response
    {
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('visit_index', [
                'id' => $visit->getId(),
            ]);
        }

        return $this->render('admin/visit/edit.html.twig', [
            'visit' => $visit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="visit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Visit $visit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($visit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('visit_index');
    }
}
