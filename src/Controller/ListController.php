<?php
namespace App\Controller;

use App\Repository\RateHousingRepository;
use App\Repository\SituationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/list")
 */
class ListController extends AbstractController
{

    /**
     * @Route("/valoraciones", name="list_rate_housing_index")
     */
    public function listRateHousing(RateHousingRepository $rateHousingRepository): Response
    {
        return $this->render('admin/list/rate_housing.html.twig', [
            'rateHousings' => $rateHousingRepository->findAll()
        ]);
    }

    /**
     * @Route("/encargo", name="list_charge_index")
     */
    public function listCharge(SituationRepository $situationRepository): Response
    {
        return $this->render('admin/list/charge.html.twig', [
            'charges' => $situationRepository->findBy(['name' => 'encargo'])
        ]);
    }

    /**
     * @Route("/autorizacion", name="list_authorization_index")
     */
    public function listAuthorization(SituationRepository $situationRepository): Response
    {
        return $this->render('admin/list/authorization.html.twig', [
            'authorizations' => $situationRepository->findBy(['name' => 'autorizacion'])
        ]);
    }

}