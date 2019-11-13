<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/atico")
 */
class PenthouseController extends AbstractController
{
    /**
     * @Route("/", name="penthouse_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('atico', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/penthouse/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
