<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $creation;

    #[ORM\Column(type: 'datetime')]
    private $miseAJour;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'topics')]
    #[ORM\JoinColumn(nullable: false)]
    private $auteur;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: Reponse::class)]
    private $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->setCreation(new DateTime('now'));
        $this->setMiseAJour(new DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getMiseAJour(): ?\DateTimeInterface
    {
        return $this->miseAJour;
    }

    public function setMiseAJour(\DateTimeInterface $miseAJour): self
    {
        $this->miseAJour = $miseAJour;

        return $this;
    }

    public function getAuteur(): ?Utilisateur
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setTopic($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getTopic() === $this) {
                $reponse->setTopic(null);
            }
        }

        return $this;
    }
}
