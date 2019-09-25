<?php

namespace App\Controller;

use App\Entity\NoteNew;
use App\Form\NoteNewType;
use App\Repository\NoteNewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note/new")
 */
class NoteNewController extends AbstractController
{
    /**
     * @Route("/", name="note_new_index", methods={"GET"})
     */
    public function index(NoteNewRepository $noteNewRepository): Response
    {
        return $this->render('note_new/index.html.twig', [
            'note_news' => $noteNewRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="note_new_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $noteNew = new NoteNew();
        $form = $this->createForm(NoteNewType::class, $noteNew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noteNew);
            $entityManager->flush();

            return $this->redirectToRoute('note_new_index');
        }

        return $this->render('note_new/new.html.twig', [
            'note_new' => $noteNew,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_new_show", methods={"GET"})
     */
    public function show(NoteNew $noteNew): Response
    {
        return $this->render('note_new/show.html.twig', [
            'note_new' => $noteNew,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_new_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NoteNew $noteNew): Response
    {
        $form = $this->createForm(NoteNewType::class, $noteNew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_new_index', [
                'id' => $noteNew->getId(),
            ]);
        }

        return $this->render('note_new/edit.html.twig', [
            'note_new' => $noteNew,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_new_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NoteNew $noteNew): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteNew->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($noteNew);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_new_index');
    }
}
