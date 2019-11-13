<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/terreno")
 */
class GroundController extends AbstractController
{
    /**
     * @Route("/", name="ground_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('terreno', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/ground/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
