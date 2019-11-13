<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/duplex")
 */
class DuplexController extends AbstractController
{
    /**
     * @Route("/", name="duplex_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('duplex', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/duplex/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
