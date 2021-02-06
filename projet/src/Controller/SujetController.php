<?php

namespace App\Controller;

use App\Entity\Sujet;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SujetController extends AbstractController
{
    /**
     * @Route("/sujet/create", name="sujet_create")
     */
    public function createSujet(): Response{
        $date = new DateTime('2000-01-01');
        $result = $date->format('Y-m-d');
        $entityManager = $this->getDoctrine()->getManager();

        $sujet = new Sujet();
        $sujet->setAuteur("Etienne Leriche");
        //$sujet->setDatePost($date);
        //Faire en sorte que le date time marche

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($sujet);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouveau sujet avec cet id : '.$sujet->getId(). '<br>'.' Et avec cet auteur : '.$sujet->getAuteur(). 
        '<br'.' Et avec cet date de publication : '.$sujet->getDatePost());
    }
    // Rajouter le Get et le Update pour le signalement
}
