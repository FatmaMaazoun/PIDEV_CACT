<?php

namespace App\Entity;

use App\Repository\CouleurEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CouleurEvenementRepository::class)
 */
class CouleurEvenement
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
    private $backgrondColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $borderColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textColor;

  

    /**
     * @ORM\OneToMany(targetEntity=SousCategorie::class, mappedBy="CouleurEvenement")
     */
    private $sousCategories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleCouleur;

    public function __construct()
    {
        $this->demandeEvenements = new ArrayCollection();
        $this->sousCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackgrondColor(): ?string
    {
        return $this->backgrondColor;
    }

    public function setBackgrondColor(string $backgrondColor): self
    {
        $this->backgrondColor = $backgrondColor;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    public function setBorderColor(string $borderColor): self
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }

   

    /**
     * @return Collection<int, SousCategorie>
     */
    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategory(SousCategorie $sousCategory): self
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories[] = $sousCategory;
            $sousCategory->setCouleurEvenement($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategorie $sousCategory): self
    {
        if ($this->sousCategories->removeElement($sousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCouleurEvenement() === $this) {
                $sousCategory->setCouleurEvenement(null);
            }
        }

        return $this;
    }

    public function getLibelleCouleur(): ?string
    {
        return $this->libelleCouleur;
    }

    public function setLibelleCouleur(string $libelleCouleur): self
    {
        $this->libelleCouleur = $libelleCouleur;

        return $this;
    }
}
