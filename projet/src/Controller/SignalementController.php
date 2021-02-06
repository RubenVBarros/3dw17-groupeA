<?php

namespace App\Controller;

use App\Entity\Signalement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignalementController extends AbstractController
{
    /**
     * @Route("/signalement/create", name="signalement_create")
     */
    public function createSignalement(): Response{
        $entityManager = $this->getDoctrine()->getManager();

        $signal = new Signalement();
        $signal->setEtat(false);
        //$signal->setDate(); <- Faire en sorte que le datetime marche
        
        $entityManager->persist($signal);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouveau signalement avec cet id : '.$signal->getId(). '<br>'. 'Avec cet état : ' .$signal->getEtat(). '<br>'. 'Et avec cette date de publication : ' .$signal->getDate());
    }

    // Rajouter le Get et le Update pour le signalement
}
