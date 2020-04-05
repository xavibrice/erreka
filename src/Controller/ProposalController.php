<?php

namespace App\Controller;

use App\Entity\Proposal;
use App\Form\Proposal1Type;
use App\Repository\ProposalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proposal")
 */
class ProposalController extends AbstractController
{
    /**
     * @Route("/", name="proposal_index", methods={"GET"})
     */
    public function index(ProposalRepository $proposalRepository): Response
    {
        return $this->render('proposal/index.html.twig', [
            'proposals' => $proposalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="proposal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $proposal = new Proposal();
        $form = $this->createForm(Proposal1Type::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proposal);
            $entityManager->flush();

            return $this->redirectToRoute('proposal_index');
        }

        return $this->render('proposal/new.html.twig', [
            'proposal' => $proposal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proposal_show", methods={"GET"})
     */
    public function show(Proposal $proposal): Response
    {
        return $this->render('proposal/show.html.twig', [
            'proposal' => $proposal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="proposal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Proposal $proposal): Response
    {
        $form = $this->createForm(Proposal1Type::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_charge_proposal', [
                'id' => $proposal->getProperty()->getId(),
                'idChargeType' => $proposal->getProperty()->getTypeProperty()->getId(),
            ]);
        }

        return $this->render('proposal/edit.html.twig', [
            'proposal' => $proposal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proposal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Proposal $proposal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($proposal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('proposal_index');
    }
}
