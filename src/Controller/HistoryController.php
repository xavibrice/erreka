<?php

namespace App\Controller;

use App\Repository\HistoricalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/historico", name="history_index")
     */
    public function index(HistoricalRepository $historicalRepository)
    {
        return $this->render('admin/history/index.html.twig', [
            'properties' => $historicalRepository->findBy(['enabled' => false]),
        ]);
    }
}
