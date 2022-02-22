<?php

namespace App\Entity;

use App\Repository\CoutCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoutCategorieRepository::class)
 */
class CoutCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;




    public function __construct()
    {
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;

        return $this;
    }



    /**
     * @return Collection<int, self>
     */
    public function getCoutCategories(): Collection
    {
        return $this->coutCategories;
    }

    public function addCoutCategory(self $coutCategory): self
    {
        if (!$this->coutCategories->contains($coutCategory)) {
            $this->coutCategories[] = $coutCategory;
            $coutCategory->setCoutcategorie($this);
        }

        return $this;
    }

    public function removeCoutCategory(self $coutCategory): self
    {
        if ($this->coutCategories->removeElement($coutCategory)) {
            // set the owning side to null (unless already changed)
            if ($coutCategory->getCoutcategorie() === $this) {
                $coutCategory->setCoutcategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CoutEvenement>
     */
    public function getCoutEvenements(): Collection
    {
        return $this->coutEvenements;
    }

    public function addCoutEvenement(CoutEvenement $coutEvenement): self
    {
        if (!$this->coutEvenements->contains($coutEvenement)) {
            $this->coutEvenements[] = $coutEvenement;
            $coutEvenement->setCoutcategorie($this);
        }

        return $this;
    }

    public function removeCoutEvenement(CoutEvenement $coutEvenement): self
    {
        if ($this->coutEvenements->removeElement($coutEvenement)) {
            // set the owning side to null (unless already changed)
            if ($coutEvenement->getCoutcategorie() === $this) {
                $coutEvenement->setCoutcategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cout>
     */
    public function getCouts(): Collection
    {
        return $this->couts;
    }
}
