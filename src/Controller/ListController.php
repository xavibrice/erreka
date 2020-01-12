<?php
namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertyReduction;
use App\Form\LocalType;
use App\Repository\ChargeTypeRepository;
use App\Repository\PropertyRepository;
use App\Repository\RateHousingRepository;
use App\Repository\SituationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'rateHousings' => $rateHousingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/exclusiva", name="list_charge_index")
     */
    public function listExclusive(Request $request,PropertyRepository $propertyRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $lastReference = $em->getRepository(Property::class)->findOneBy([], ['id' => 'desc']);

        if ($lastReference) {
            $newReference = $lastReference->getReference() + 1;
        } else {
            $newReference = 1;
        }

        $local = new Property();
        $formLocal = $this->createForm(LocalType::class, $local);

        $formLocal->handleRequest($request);

        if ($formLocal->isSubmitted() && $formLocal->isValid()) {
            $local->setReference($newReference);
            $em->persist($local);
            $em->flush();

            $this->addFlash('success', 'Local creado correctamente');
            return $this->redirectToRoute($request->attributes->get('_route'));
        }


        return $this->render('admin/list/exclusive.html.twig', [
            'exclusives' => $propertyRepository->onlyExclusives($this->getUser()),
            'formLocal' => $formLocal->createView(),
        ]);
    }

    /**
     * @Route("/autorizacion", name="list_authorization_index")
     */
    public function listAuthorization(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/list/authorization.html.twig', [
            'authorizations' => $propertyRepository->onlyAuthorization($this->getUser())
        ]);
    }

}