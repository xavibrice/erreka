<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/trastero")
 */
class StorageRoomController extends AbstractController
{
    /**
     * @Route("/", name="storage_room_index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()
            ->getRepository(Property::class)
            ->chargeForSituation('trastero', 'exclusiva', $this->getUser())
        ;
        return $this->render('charge/storage_room/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
