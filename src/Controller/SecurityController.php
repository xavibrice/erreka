<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $arrayData = $this->getPhrases();
        $idArray = array_rand($this->getPhrases(), 1);

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'phrase' => $arrayData[$idArray]]);
    }

    public function getPhrases(): array
    {
        return [
            'Cada día es una nueva oportunidad para cambiar tu vida.',
            'Ningún mar en calma hizo experto a un marinero.',
            'El éxito en la vida no se mide por lo que logras sino por los obstáculos que superas.',
            'Mañana es una excusa maravillosa, ¿No crees?',
            'Eres suficiente tal y como eres.',
            'Debes hacer las cosas que crees que no puedes hacer.',
            'Tu mejor profesor es tu mayor error.',
            'No busques el momento perfecto, solo busca el momento y hazlo perfecto.',
            'Levántate, suspira, sonríe, y sigue adelante.',
            'Dale a cada día la posibilidad de ser el mejor día de tu vida.',
        ];
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \Exception("Don't forget to activate logout in security.yaml");
    }
}
