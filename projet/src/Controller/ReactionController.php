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
