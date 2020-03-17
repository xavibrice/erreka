<?php

namespace App\Controller;

use App\Entity\NoteCommercial;
use App\Form\NoteCommercialType;
use App\Repository\NoteCommercialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/admin2/note/commercial")
 */
class NoteCommercialController extends AbstractController
{

    /**
     * @Route("/", name="note_commercial_index", methods={"GET"})
     */
    public function index(NoteCommercialRepository $noteCommercialRepository): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            $noteCommercials = $noteCommercialRepository->findAgency($this->getUser()->getAgency());
        } else {
            $noteCommercials = $noteCommercialRepository->findAgencyAndAgent($this->getUser()->getAgency(), $this->getUser());
        }


        return $this->render('admin/note_commercial/index.html.twig', [
            'note_commercials' => $noteCommercials
        ]);
    }

    /**
     * @Route("/new", name="note_commercial_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $noteCommercial = new NoteCommercial();
        $noteCommercial->setFromCommercial($this->getUser());
        $form = $this->createForm(NoteCommercialType::class, $noteCommercial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noteCommercial);
            $entityManager->flush();

            return $this->redirectToRoute('note_commercial_index');
        }

        return $this->render('admin/note_commercial/new.html.twig', [
            'note_commercial' => $noteCommercial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_commercial_show", methods={"GET"})
     */
    public function show(NoteCommercial $noteCommercial): Response
    {
        return $this->render('admin/note_commercial/show.html.twig', [
            'note_commercial' => $noteCommercial,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_commercial_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NoteCommercial $noteCommercial): Response
    {
        $form = $this->createForm(NoteCommercialType::class, $noteCommercial, [
            //'agency' => $this->getUser()->getAgency()->getName()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_commercial_index', [
                'id' => $noteCommercial->getId(),
            ]);
        }

        return $this->render('admin/note_commercial/edit.html.twig', [
            'note_commercial' => $noteCommercial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_commercial_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NoteCommercial $noteCommercial): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteCommercial->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($noteCommercial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_commercial_index');
    }

}
