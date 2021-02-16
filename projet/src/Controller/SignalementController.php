<?php

namespace App\Controller;

use App\Entity\Signalement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignalementController extends AbstractController
{
    /**
     * @Route("/signalement", name="signalement_create")
     */
    public function index(): Response
    {
        return $this->render('signalement/index.html.twig', [
            'signal' => 'SignalementController',
        ]);
    }
    
}
