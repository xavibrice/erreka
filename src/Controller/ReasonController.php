<?php

namespace App\Controller;

use App\Entity\Reason;
use App\Form\ReasonType;
use App\Repository\ReasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin2/reason")
 */
class ReasonController extends AbstractController
{
    /**
     * @Route("/", name="reason_index", methods={"GET"})
     */
    public function index(ReasonRepository $reasonRepository): Response
    {
        return $this->render('admin/reason/index.html.twig', [
            'reasons' => $reasonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reason_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reason = new Reason();
        $form = $this->createForm(ReasonType::class, $reason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reason);
            $entityManager->flush();

            return $this->redirectToRoute('reason_index');
        }

        return $this->render('admin/reason/new.html.twig', [
            'reason' => $reason,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reason_show", methods={"GET"})
     */
    public function show(Reason $reason): Response
    {
        return $this->render('admin/reason/show.html.twig', [
            'reason' => $reason,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reason_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reason $reason): Response
    {
        $form = $this->createForm(ReasonType::class, $reason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reason_index', [
                'id' => $reason->getId(),
            ]);
        }

        return $this->render('admin/reason/edit.html.twig', [
            'reason' => $reason,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reason_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reason $reason): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reason->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reason_index');
    }
}
