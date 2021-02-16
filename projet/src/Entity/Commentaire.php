<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=sujet::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sujet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getAuteur(): ?user
    {
        return $this->auteur;
    }

    public function setAuteur(?user $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getSujet(): ?sujet
    {
        return $this->sujet;
    }

    public function setSujet(?sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }
}
