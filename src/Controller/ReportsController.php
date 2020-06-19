<?php
namespace App\Controller;

use App\Entity\SearchReports;
use App\Form\SearchReportsType;
use App\Repository\ChargeRepository;
use App\Repository\PropertyReductionRepository;
use App\Repository\PropertyRepository;
use App\Repository\ProposalRepository;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportsController extends AbstractController
{
    /**
     * @Route("/admin/reportes", name="reports_index")
     */
    public function index(Request $request, PropertyRepository $propertyRepository, ChargeRepository $chargeRepository, VisitRepository $visitRepository, ProposalRepository $proposalRepository, PropertyReductionRepository $propertyReductionRepository): Response
    {
        $searchReports = new SearchReports();
        $form = $this->createForm(SearchReportsType::class, $searchReports);
        $form->handleRequest($request);

        $noticies = $propertyRepository->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.created BETWEEN :start AND :end')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'Noticia')
            ->getQuery()
            ->getResult()
        ;

        $valorations = $propertyRepository->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->innerJoin('p.rateHousing', 'rh')
            ->andWhere('p.created BETWEEN :start AND :end')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $noticiesToDevelopers = $propertyRepository->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.created BETWEEN :start AND :end')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'Noticia a desarrollar')
            ->getQuery()
            ->getResult()
        ;

        $chargeSell = $chargeRepository->createQueryBuilder('c')
            ->innerJoin('c.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('c.start_date BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Venta')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $chargeRent = $chargeRepository->createQueryBuilder('c')
            ->innerJoin('c.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('c.start_date BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Alquiler')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $visitSell = $visitRepository->createQueryBuilder('v')
            ->innerJoin('v.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('v.visited BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Venta')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $visitRent = $visitRepository->createQueryBuilder('v')
            ->innerJoin('v.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('v.visited BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Alquiler')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $proposalRent = $proposalRepository->createQueryBuilder('pro')
            ->innerJoin('pro.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pro.created BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Alquiler')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $proposalSell = $proposalRepository->createQueryBuilder('pro')
            ->innerJoin('pro.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pro.created BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Venta')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $contractRent = $proposalRepository->createQueryBuilder('pro')
            ->innerJoin('pro.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pro.contract BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Alquiler')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $contractSell = $proposalRepository->createQueryBuilder('pro')
            ->innerJoin('pro.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pro.contract BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Venta')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $reductionSell = $propertyReductionRepository->createQueryBuilder('pr')
            ->innerJoin('pr.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pr.reduction_date BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Venta')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $reductionRent = $propertyReductionRepository->createQueryBuilder('pr')
            ->innerJoin('pr.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pr.reduction_date BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Alquiler')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        $scriptures = $proposalRepository->createQueryBuilder('pro')
            ->innerJoin('pro.property', 'p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('pro.scriptures BETWEEN :start AND :end')
            ->andWhere('s.name = :situation')
            ->andWhere('r.name = :reason')
            ->setParameter('reason', 'Venta')
            ->setParameter('situation', 'Noticia')
            ->setParameter('start', $form->get('start')->getData())
            ->setParameter('end', $form->get('end')->getData())
            ->getQuery()
            ->getResult()
        ;

        return $this->render('admin/reports/index.html.twig', [
            'noticies' => $noticies,
            'noticiesToDeveloper' => $noticiesToDevelopers,
            'valorations' => $valorations,
            'chargesRent' => $chargeRent,
            'chargesSell' => $chargeSell,
            'visitsRent' => $visitRent,
            'visitsSell' => $visitSell,
            'proposalRent' => $proposalRent,
            'proposalSell' => $proposalSell,
            'contractRent' => $contractRent,
            'contractSell' => $contractSell,
            'reductionSell' => $reductionSell,
            'reductionRent' => $reductionRent,
            'scriptures' => $scriptures,
            'form' => $form->createView(),
        ]);
    }
}