<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;


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
    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function showId(int $id, UserRepository $userRepository): Response{
        $user = $userRepository
            ->find($id);
            return new Response('Nom du user : '.$user->getNom().
                '<br>'.'Prenom du user : '.$user->getPrenom().
                '<br>'.'Email du user : '.$user->getEmail().
                '<br>'.'Adresse du user : '.$user->getAdresse().
                '<br>'.'Téléphone du user : '.$user->getTelephone().
                '<br>'.'Mot de passe du user : '.$user->getMotdepasse().
                '<br>'.'Rôle du user : '.$user->getROLE().
                '<br>'.'Identifiant du user : '.$user->getIdentifiant());
    }
    /**
     * @Route("/user/edit/{id}")
     */
    public function update(int $id): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if(!$user){
            throw $this->createNotFoundException('Pas de user avec cet id' . $id);
        }

        $user->setNom('Maxwell');
        $entityManager->flush();

        return $this->redirectToRoute('user_show',[
            'id'=>$user->getId()
        ]);
    }
}
