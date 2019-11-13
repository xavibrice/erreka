<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/garaje")
 */
class GarageController extends AbstractController
{
    /**
     * @Route("/", name="garage_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('garaje', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/garage/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
