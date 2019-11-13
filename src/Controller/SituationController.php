<?php

namespace App\Controller;

use App\Entity\Reason;
use App\Entity\Situation;
use App\Form\SituationType;
use App\Repository\SituationRepository;
use App\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/situation")
 */
class SituationController extends AbstractController
{
    /**
     * @Route("/", name="situation_index", methods={"GET"})
     */
    public function situations(SituationRepository $situationRepository): Response
    {
        return $this->render('admin/situation/index.html.twig', [
            'situations' => $situationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="situation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $situation = new Situation();
        $form = $this->createForm(SituationType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $situation->setNameSlug(Slugger::slugify($situation->getName()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($situation);
            $entityManager->flush();

            return $this->redirectToRoute('situation_index');
        }

        return $this->render('admin/situation/new.html.twig', [
            'situation' => $situation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situation_show", methods={"GET"})
     */
    public function show(Situation $situation): Response
    {
        return $this->render('admin/situation/show.html.twig', [
            'situation' => $situation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="situation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Situation $situation): Response
    {
        $form = $this->createForm(SituationType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('situation_index', [
                'id' => $situation->getId(),
            ]);
        }

        return $this->render('admin/situation/edit.html.twig', [
            'situation' => $situation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Situation $situation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$situation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($situation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('situation_index');
    }

    /**
     * @Route("/situation_reason", name="reasons_by_situation", condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'")
     */
    public function reasonsBySituation(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $situation_id = $request->request->get('situation_id');
        $reasons = $em->getRepository(Reason::class)->findByReason($situation_id);

        return new JsonResponse($reasons);
    }
}
