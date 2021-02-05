<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="create_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/create", name="create_user")
     */
    public function createUser(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        //On set et on prépare les données pour l'envoi vers la bdd
        $user = new User();
        $user->setNom('Endle');
        $user->setPrenom('Lucka');
        $user->setEmail('applefan@gmail.fr');
        $user->setAdresse('1 Rue Jouy aux Arches');
        $user->setTelephone('07164652317');
        $user->setMotdepasse('LuckaetEmma');
        $user->setROLE('user');
        $user->setIdentifiant('Apraaw');

        // Doctrine sauvegarde le user
        $entityManager->persist($user);

        //Execution de la requête
        $entityManager->flush();

        return new Response('Nouveau user avec cet id '.$user->getId());
    }
}
