<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $estUtile;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $noteur;

    #[ORM\ManyToMany(targetEntity: Reponse::class, inversedBy: 'notes')]
    private $reponse;

    public function __construct()
    {
        $this->reponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstUtile(): ?bool
    {
        return $this->estUtile;
    }

    public function setEstUtile(bool $estUtile): self
    {
        $this->estUtile = $estUtile;

        return $this;
    }

    public function getNoteur(): ?Utilisateur
    {
        return $this->noteur;
    }

    public function setNoteur(?Utilisateur $noteur): self
    {
        $this->noteur = $noteur;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse[] = $reponse;
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        $this->reponse->removeElement($reponse);

        return $this;
    }
}
