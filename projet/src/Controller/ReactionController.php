<?php

namespace App\Controller;

use App\Entity\Reaction;
use App\Entity\Sujet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReactionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


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

    /**
     * @Route("/reaction/{sujet}/{type}", name="reaction-toggle")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function toggleReaction(int $sujet, string $type): Response{
        if($type === "like" || $type === "dislike"){
            $entityManager = $this->getDoctrine()->getManager();
            $repo = $entityManager->getRepository(Reaction::class);
            $user = $this->getUser();
            $reac = $repo->findOne($sujet,$user->getId());
            $sujet = $entityManager->getRepository(Sujet::class)->find($sujet);
            if($sujet){
                $typeReac = ($type === "like");
                if($reac == null){
                    $reac = new Reaction();
                    $reac->setAuteur($user);
                    $reac->setSujet($sujet);
                    $reac->setEtat($typeReac);
                    $entityManager->persist($reac);
                } else {
                    // même type de réaction
                    if($reac->getEtat() == ($typeReac) ){
                        // supprimer 
                        $entityManager->remove($reac);
                    } else {
                        // modifier le type
                        $reac->setEtat($typeReac);
                    }
                }
                $entityManager->flush();
            }
            
        }
        


        return $this->redirectToRoute('sujet_show',[
            "id"=>$sujet->getId()
        ]);
    }
}
