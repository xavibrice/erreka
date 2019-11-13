<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/apartamento")
 */
class ApartamentController extends AbstractController
{
    /**
     * @Route("/", name="apartament_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('apartamento', 'exclusiva', $this->getUser())
        ;

        return $this->render('charge/apartament/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
