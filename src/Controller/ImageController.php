<?php

namespace App\Controller;

use App\Entity\Images;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/image")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/{id}", name="image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Images $images): Response
    {
        if ($this->isCsrfTokenValid('delete'.$images->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($images);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_rate_housing_new_show', [
            'id' => $images->getProperty()->getId()
        ]);
    }
}
