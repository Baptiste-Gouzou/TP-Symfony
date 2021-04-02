<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Stage::class, mappedBy="formations")
     */
    private $Stages;

    public function __construct()
    {
        $this->Stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->Stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->Stages->contains($stage)) {
            $this->Stages[] = $stage;
            $stage->addFormation($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->Stages->removeElement($stage)) {
            $stage->removeFormation($this);
        }

        return $this;
    }

    public function __toString(): string
    {
      return $this->getNom();
    }
}
