<?php

namespace App\Controller;

use App\Entity\Zone;
use App\Form\ZoneType;
use App\Repository\ZoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin2/zone")
 */
class ZoneController extends AbstractController
{
    /**
     * @Route("/", name="zone_index", methods={"GET"})
     */
    public function index(ZoneRepository $zoneRepository): Response
    {
        return $this->render('admin/zone/index.html.twig', [
            'zones' => $zoneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zone_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $zone = new Zone();
        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($zone);
            $entityManager->flush();

            return $this->redirectToRoute('zone_index');
        }

        return $this->render('admin/zone/new.html.twig', [
            'zone' => $zone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zone_show", methods={"GET"})
     */
    public function show(Zone $zone): Response
    {
        return $this->render('admin/zone/show.html.twig', [
            'zone' => $zone,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="zone_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Zone $zone): Response
    {
        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zone_index', [
                'id' => $zone->getId(),
            ]);
        }

        return $this->render('admin/zone/edit.html.twig', [
            'zone' => $zone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zone_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Zone $zone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zone->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($zone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('zone_index');
    }
}
