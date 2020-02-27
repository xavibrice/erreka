<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Offered;
use App\Entity\Property;
use App\Form\OfferedType;
use App\Repository\OfferedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offered")
 */
class OfferedController extends AbstractController
{
    /**
     * @Route("/", name="offered_index", methods={"GET"})
     */
    public function index(OfferedRepository $offeredRepository): Response
    {
        return $this->render('offered/index.html.twig', [
            'offereds' => $offeredRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{idClient}/{idProperty}", name="offered_new")
     */
    public function offered($idClient, $idProperty)
    {
        //dd($idClient . $idProperty);
        $entityManager = $this->getDoctrine()->getManager();

        $client = $entityManager->getRepository(Client::class)->find($idClient);
        $property = $entityManager->getRepository(Property::class)->find($idProperty);

        $offered = new Offered();
        $offered->setCreated(new \DateTime());
        $offered->setProperty($property);
        $offered->setClient($client);
//        $form = $this->createForm(OfferedType::class, $offered);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offered);
            $entityManager->flush();

            return $this->redirectToRoute('client_possible_visits', [
                'id' => $idClient
            ]);
//        }

//        return $this->render('offered/new.html.twig', [
//            'offered' => $offered,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="offered_show", methods={"GET"})
     */
    public function show(Offered $offered): Response
    {
        return $this->render('offered/show.html.twig', [
            'offered' => $offered,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offered_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offered $offered): Response
    {
        $form = $this->createForm(OfferedType::class, $offered);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offered_index', [
                'id' => $offered->getId(),
            ]);
        }

        return $this->render('offered/edit.html.twig', [
            'offered' => $offered,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{idClient}", name="offered_delete")
     */
    public function delete(Request $request, Offered $offered, $idClient): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offered);
            $entityManager->flush();

        return $this->redirectToRoute('client_possible_visits', [
            'id' => $idClient
        ]);
    }
}
