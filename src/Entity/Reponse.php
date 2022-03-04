<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private $auteur;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private $topic;

    #[ORM\ManyToMany(targetEntity: Note::class, mappedBy: 'reponse')]
    private $notes;

    private $noteGlobale;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

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

    public function getAuteur(): ?Utilisateur
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->addReponse($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            $note->removeReponse($this);
        }

        return $this;
    }

    public function getNoteGlobale(): ?int
    {
        return $this->noteGlobale;
    }

    public function setNoteGlobale(): self
    {
        $i = 0;
        $this->noteGlobale = 0;
        $notes = $this->getNotes();
        while($notes[$i]) {
            $this->noteGlobale += $notes[$i]->getEstUtile()? 1:0;
            $i++;
        }

        return $this;
    }
}
