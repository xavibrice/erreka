<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/bar")
 */
class PubController extends AbstractController
{
    /**
     * @Route("/", name="pub_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('bar', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/pub/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
