<?php

namespace App\Controller;

use App\Entity\Reaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReactionRepository;



class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction/create", name="reaction_create")
     */
    public function createReaction(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $reac = new Reaction();
        $reac->setEtat(true);

        $entityManager->persist($reac);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouvelle réaction avec cet id : '.$reac->getId(). '<br>'. 'Et avec cet état : '.$reac->getEtat());
    }
     /**
     * @Route("/reaction/{id}", name="reaction_show")
     */
    public function showId(int $id, ReactionRepository $reactionRepository): Response{
        $reac = $reactionRepository
            ->find($id);
            return new Response('Regardez cet état de la réaction : '.$reac->getEtat());
    }
    /**
     * @Route("/reaction/edit/{id}")
     */
    public function update(int $id): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $reac = $entityManager->getRepository(Reaction::class)->find($id);

        if(!$reac){
            throw $this->createNotFoundException('Pas de réaction avec cet id' . $id);
        }

        $reac->setEtat(true);
        $entityManager->flush();

        return $this->redirectToRoute('reaction_show',[
            'id'=>$reac->getId()
        ]);
    }
}
