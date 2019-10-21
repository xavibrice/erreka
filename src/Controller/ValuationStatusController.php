<?php

namespace App\Controller;

use App\Entity\ValuationStatus;
use App\Form\ValuationStatusType;
use App\Repository\ValuationStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/valuation/status")
 */
class ValuationStatusController extends AbstractController
{
    /**
     * @Route("/", name="valuation_status_index", methods={"GET"})
     */
    public function index(ValuationStatusRepository $valuationStatusRepository): Response
    {
        return $this->render('valuation_status/index.html.twig', [
            'valuation_statuses' => $valuationStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="valuation_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $valuationStatus = new ValuationStatus();
        $form = $this->createForm(ValuationStatusType::class, $valuationStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($valuationStatus);
            $entityManager->flush();

            return $this->redirectToRoute('valuation_status_index');
        }

        return $this->render('valuation_status/new.html.twig', [
            'valuation_status' => $valuationStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="valuation_status_show", methods={"GET"})
     */
    public function show(ValuationStatus $valuationStatus): Response
    {
        return $this->render('valuation_status/show.html.twig', [
            'valuation_status' => $valuationStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="valuation_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ValuationStatus $valuationStatus): Response
    {
        $form = $this->createForm(ValuationStatusType::class, $valuationStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('valuation_status_index', [
                'id' => $valuationStatus->getId(),
            ]);
        }

        return $this->render('valuation_status/edit.html.twig', [
            'valuation_status' => $valuationStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="valuation_status_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ValuationStatus $valuationStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$valuationStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($valuationStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('valuation_status_index');
    }
}
