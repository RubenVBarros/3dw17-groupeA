<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;


class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/create", name="create_categorie")
     */
    public function createCategorie(): Response {
        $entityManager = $this->getDoctrine()->getManager();
        
        $categ = new Categorie();
        $categ->setTitre("Les restaurants en France");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($categ);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouvelle catégorie avec cet id : '.$categ->getId(). '<br>'.' Et avec ce nom : '.$categ->getTitre());
    }
    /**
     * @Route("/categorie/{id}", name="categorie_show")
     */
    public function showId(int $id, CategorieRepository $categRepository): Response {
        $categ = $categRepository
            ->find($id);
            return new Response('Titre de la categorie : '.$categ->getTitre());
    }
    /**
     * @Route("/categorie/edit/{id}")
     */
    public function update(int $id): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $categ = $entityManager->getRepository(Categorie::class)->find($id);

        if(!$categ){
            throw $this->createNotFoundException('Pas de catégorie avec cet id' . $id);
        }

        $categ->setTitre("Les pays");
        $entityManager->flush();

        return $this->redirectToRoute('categorie_show',[
            'id'=>$categ->getId()
        ]);
    }

}
