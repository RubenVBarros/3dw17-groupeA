<?php

namespace App\Controller;

use App\Entity\Signalement;
use App\Entity\Sujet;
use App\Form\SignalementType;
use App\Repository\SignalementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/signalement")
 */
class SignalementController extends AbstractController
{
    /**
     * @Route("/new/{sujet_id}", name="signalement_new", methods={"GET","POST"})
     * @ParamConverter("sujet", options={"mapping":{"sujet_id":"id"}})
     */
    public function new(Request $request,Sujet $sujet): Response
    {
        $signalement = new Signalement();
        $form = $this->createForm(SignalementType::class, $signalement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $signalement->setSujet($sujet);
            $signalement->setAuteur($this->getUser());
            $entityManager->persist($signalement);
            $entityManager->flush();

            return $this->redirectToRoute('sujet_index');
        }

        return $this->render('signalement/new.html.twig', [
            'signalement' => $signalement,
            'form' => $form->createView(),
        ]);
    }
}
