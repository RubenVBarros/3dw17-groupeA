<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\Commentaire;
use App\Entity\Reaction;
use App\Form\SujetType;
use App\Form\CommentaireType;
use App\Repository\SujetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/sujet")
 */
class SujetController extends AbstractController
{
    /**
     * @Route("/", name="sujet_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SujetRepository $sujetRepository): Response
    {
        return $this->render('sujet/index.html.twig', [
            'sujets' => $sujetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sujet_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $sujet = new Sujet();
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sujet->setAuteur($user);
            $entityManager->persist($sujet);
            $entityManager->flush();

            return $this->redirectToRoute('sujet_index');
        }

        return $this->render('sujet/new.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sujet_show", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function show(Request $request, Sujet $sujet): Response
    {   
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        if($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();

            $commentaire->setSujet($sujet);
            $commentaire->setAuteur($this->getUser());
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $sujet->addCommentaire($commentaire);
            //return $this->redirectToRoute("sujet_show");
        }
        $em = $entityManager->getRepository(Reaction::class);
        
        $likes = $em->getLikes($sujet->getId());
        $dislikes = $em->getDislikes($sujet->getId());
        $status = $em->findOne($sujet->getId(),$this->getUser()->getId());
        $reaction = -1;
        if($status){
            $reaction = $status->getEtat() ? 1 : 0;
        }
        if ($this->isGranted('ROLE_ADMIN')) {
            $editPossible = 1;
        }
        if ($sujet->isPossibleEdit())$editPossible = 1;
        else $editPossible = 0;
        
        return $this->render('sujet/show.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
            'commentaires' => $sujet->getCommentaires(),
            'likes'=>$likes,
            'dislikes'=>$dislikes,
            'reaction'=>$reaction,
            'editPossible'=>$editPossible
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sujet_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Sujet $sujet): Response
    {
        if(!($sujet->isPossibleEdit()) || !($sujet->getAuteur() === $this->getUser())) {
            if(!($this->isGranted('ROLE_ADMIN'))){
                 return $this->redirectToRoute('sujet_index');
            }
        }
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sujet_index');
        }

        return $this->render('sujet/edit.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sujet_delete", methods={"DELETE"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete(Request $request, Sujet $sujet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sujet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sujet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sujet_index');
    }
}
