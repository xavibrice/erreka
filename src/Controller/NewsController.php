<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\NoteNew;
use App\Entity\RateHousing;
use App\Entity\Reason;
use App\Entity\Street;
use App\Entity\Zone;
use App\Form\NewsToDevelopType;
use App\Form\NewsType;
use App\Form\NewType;
use App\Form\NoteNewType;
use App\Form\RateHousingType;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/noticia")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/alquilado", name="news_rented", methods={"GET", "POST"})
     */
    public function newsRented(Request $request, NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findBySituation('noticia', $this->getUser());

        return $this->render('admin/news/news_rented.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/noticia", name="news", methods={"GET", "POST"})
     */
    public function news(Request $request, NewsRepository $newsRepository): Response
    {
        $new = new News();
        $new->setCommercial($this->getUser());
        $form = $this->createForm(NewsType::class, $new);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($new);
            $entityManager->flush();

            $this->addFlash('success', 'Noticia creada correctamente');
            return $this->redirectToRoute('news');
        }

        $news = $newsRepository->findBySituation('noticia', $this->getUser());

        return $this->render('admin/news/news.html.twig', [
            'news' => $news,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/noticia-a-desarrollar", name="news_to_develop", methods={"GET", "POST"})
     */
    public function newsToDevelop(Request $request, NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findBySituation('noticia-a-desarrollar', $this->getUser());

        $new = new News();
        $new->setCommercial($this->getUser());
        $form = $this->createForm(NewsToDevelopType::class, $new);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($new);
            $entityManager->flush();

            $this->addFlash('success', 'Noticia a desarrollar creada correctamente');
            return $this->redirectToRoute('news_to_develop');
        }

        return $this->render('admin/news/news_to_develop.html.twig', [
            'news' => $news,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/noticia-a-desarrollar/{id}/edit", name="news_edit_new", methods={"GET","POST"})
     */
    public function editNewsNew(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsToDevelopType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Noticia editada correctamente');

            return $this->redirectToRoute('news_to_develop');
        }

        return $this->render('admin/news/news_to_develop_edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/noticia-a-desarrollar/{id}", name="news_to_develop_show", methods={"GET", "POST"})
     */
    public function showNewToDevelop(Request $request, News $news): Response
    {
        $noteNew = new NoteNew();
        $noteNew->setNew($news);
        $form = $this->createForm(NoteNewType::class, $noteNew);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noteNew);
            $entityManager->flush();

            $this->addFlash('success', 'Nota creada correctamente');
            return $this->redirectToRoute('news_to_develop_show', ['id' => $news->getId()]);
        }

        return $this->render('admin/news/news_to_develop_show.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/", name="news_index", methods={"GET", "POST"})
//     */
//    public function index(Request $request, NewsRepository $newsRepository): Response
//    {
//        $news = $newsRepository->findBy(['commercial' => $this->getUser()], ['created' => 'ASC']);
//        if ($this->isGranted('ROLE_ADMIN')) {
//            $news = $newsRepository->findAll();
//        }
//
//        $new = new News();
//        $new->setCreated(new \DateTime());
//        $new->setCommercial($this->getUser());
//        $form = $this->createForm(NewsType::class, $new);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($new);
//            $entityManager->flush();
//
//            $this->addFlash('success', 'Noticia creada correctamente');
//            return $this->redirectToRoute('news_index');
//        }
//
//        return $this->render('admin/news/index.html.twig', [
//            'news' => $news,
////            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/new", name="news_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $news = new News();
//        $news->setCommercial($this->getUser());
//        $form = $this->createForm(NewType::class, $news);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($news);
//            $entityManager->flush();
//
//            $this->addFlash('success', 'Noticia creada correctamente');
//            return $this->redirectToRoute('news_index');
//        }
//
//        return $this->render('admin/news/new.html.twig', [
//            'news' => $news,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    public function newForm(): Response
//    {
//        $news = new News();
//        $news->setCommercial($this->getUser());
//        $form = $this->createForm(NewType::class, $news);
//
//        return $this->render('admin/news/new_form.html.twig', [
//            'form' => $form->createView()
//        ]);
//    }

    /**
     * @Route("/{id}", name="news_show", methods={"GET", "POST"})
     */
    public function show(Request $request, News $news): Response
    {
        $noteNew = new NoteNew();
        $noteNew->setNew($news);
        $form = $this->createForm(NoteNewType::class, $noteNew);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noteNew);
            $entityManager->flush();

            $this->addFlash('success', 'Nota creada correctamente');
            return $this->redirectToRoute('news_show', ['id' => $news->getId()]);
        }

        $rateHousing = new RateHousing();
        $rateHousing->setNew($news);
        $formRate = $this->createForm(RateHousingType::class, $rateHousing);
        $formRate->handleRequest($request);
        if ($formRate->isSubmitted() && $formRate->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rateHousing);
            $entityManager->flush();

            $this->addFlash('success', 'Valoración creada correctamente');
            return $this->redirectToRoute('news_show', ['id' => $news->getId()]);
//                    return $this->redirectToRoute('news_index');
        }

        return $this->render('admin/news/show.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
            'formRate' => $formRate->createView(),
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

            return $this->redirectToRoute('news', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('admin/news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="news_delete", methods={"DELETE"})
     */
    public function deleteNew(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news');
    }

    /**
     * @Route("/delete-to-develop/{id}", name="news_to_develop_delete", methods={"DELETE"})
     */
    public function deleteNewToDevelop(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_to_develop');
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
