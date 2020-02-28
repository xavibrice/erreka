<?php

namespace App\Controller;

use App\Entity\NoteClient;
use App\Form\NoteClientType;
use App\Repository\NoteClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note/client")
 */
class NoteClientController extends AbstractController
{
    /**
     * @Route("/", name="note_client_index", methods={"GET"})
     */
    public function index(NoteClientRepository $noteClientRepository): Response
    {
        return $this->render('admin/note_client/index.html.twig', [
            'note_clients' => $noteClientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="note_client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $noteClient = new NoteClient();
        $form = $this->createForm(NoteClientType::class, $noteClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noteClient);
            $entityManager->flush();

            return $this->redirectToRoute('note_client_index');
        }

        return $this->render('admin/note_client/new.html.twig', [
            'note_client' => $noteClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_client_show", methods={"GET"})
     */
    public function show(NoteClient $noteClient): Response
    {
        return $this->render('admin/note_client/show.html.twig', [
            'note_client' => $noteClient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NoteClient $noteClient): Response
    {
        $form = $this->createForm(NoteClientType::class, $noteClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_client_index', [
                'id' => $noteClient->getId(),
            ]);
        }

        return $this->render('admin/note_client/edit.html.twig', [
            'note_client' => $noteClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NoteClient $noteClient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteClient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($noteClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_client_index');
    }
}
