<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/vivienda")
 */
class LivingPlaceController extends AbstractController
{
    /**
     * @Route("/", name="living_place_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('vivienda', 'Exclusiva', $this->getUser())
        ;
        return $this->render('charge/living_place/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
