<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentaireRepository;


class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire/create", name="commentaire_create")
     */
    public function createCommentaire(): Response{
        $entityManager = $this->getDoctrine()->getManager();

        $com = new Commentaire();
        $com->setContenu("Je pense que l'antidatage des stock-options est une chose très quantifiable");

        $entityManager->persist($com);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouveau commentaire avec cet id : '.$com->getId(). '<br>'. 'Et avec ce contenu : '.$com->getContenu());
    }
    /**
     * @Route("/commentaire/{id}", name="commentaire_show")
     */
    public function showId(int $id, CommentaireRepository $comRepository): Response{
        $com = $comRepository
            ->find($id);
            return new Response('Contenu du commentaire : '.$com->getContenu());
    }
    /**
     * @Route("/commentaire/edit/{id}")
     */
    public function update(int $id): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $com = $entityManager->getRepository(Commentaire::class)->find($id);

        if(!$com){
            throw $this->createNotFoundException('Pas de commentaire avec cet id' . $id);
        }

        $com->setContenu("Je pense que je suis le plus fort");
        $entityManager->flush();

        return $this->redirectToRoute('commentaire_show',[
            'id'=>$com->getId()
        ]);
    }
}
