<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/chalet")
 */
class ChaletController extends AbstractController
{
    /**
     * @Route("/", name="chalet_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('chalet', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/chalet/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
