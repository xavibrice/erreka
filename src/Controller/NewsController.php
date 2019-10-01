<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Reason;
use App\Entity\Street;
use App\Entity\Zone;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin2/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news_index", methods={"GET"})
     */
    public function index(NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findBy(['commercial' => $this->getUser()]);
        if ($this->isGranted('ROLE_ADMIN')) {
            $news = $newsRepository->findAll();
        }

        return $this->render('admin/news/index.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/new", name="news_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $news = new News();
        $news->setCommercial($this->getUser());
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'Noticia creada correctamente');
            return $this->redirectToRoute('news_index');
        }

        return $this->render('admin/news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        return $this->render('admin/news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Noticia editada correctamente');

            return $this->redirectToRoute('news_index', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('admin/news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_delete", methods={"DELETE"})
     */
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_index');
    }

//    /**
//     * @Route("/zone_street", name="zone_by_street", condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'")
//     */
//    public function zoneByStreet(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $zone_id = $request->request->get('zone_id');
//        $zones = $em->getRepository(Street::class)->findByStreets($zone_id);
//
//        return new JsonResponse($zones);
//    }

//    /**
//     * @Route("/situation_reason", name="situation_by_reason", condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'")
//     */
//    public function situationByReason(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $situation_id = $request->request->get('situation_id');
//        $situations = $em->getRepository(Reason::class)->findByReasons($situation_id);
//
//        return new JsonResponse($situations);
//    }
}
