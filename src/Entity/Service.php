<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Medecin", mappedBy="service")
     */
    private $medecins;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Specialite", mappedBy="service")
     */
    private $specilites;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
        $this->specilites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Medecin[]
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(Medecin $medecin): self
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins[] = $medecin;
            $medecin->setService($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): self
    {
        if ($this->medecins->contains($medecin)) {
            $this->medecins->removeElement($medecin);
            // set the owning side to null (unless already changed)
            if ($medecin->getService() === $this) {
                $medecin->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Specialite[]
     */
    public function getSpecilites(): Collection
    {
        return $this->specilites;
    }

    public function addSpecilite(Specialite $specilite): self
    {
        if (!$this->specilites->contains($specilite)) {
            $this->specilites[] = $specilite;
            $specilite->setService($this);
        }

        return $this;
    }

    public function removeSpecilite(Specialite $specilite): self
    {
        if ($this->specilites->contains($specilite)) {
            $this->specilites->removeElement($specilite);
            // set the owning side to null (unless already changed)
            if ($specilite->getService() === $this) {
                $specilite->setService(null);
            }
        }

        return $this;
    }
}
