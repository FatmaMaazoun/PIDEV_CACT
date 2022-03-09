<?php

namespace App\Entity;

use App\Repository\CoutEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CoutEvenementRepository::class)
 */
class CoutEvenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\NotBlank(message="nbr billet est obligatoire")
     */
    private $NbBillet;

    /**
     * @ORM\Column(type="float")
     *  @Assert\NotBlank(message="prix est obligatoire")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=CoutCategorie::class, inversedBy="coutEvenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coutcategorie;

    /**
     * @ORM\ManyToOne(targetEntity=DemandeEvenement::class, inversedBy="coutEvenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $demandeEvent;

    /**
     * @ORM\OneToMany(targetEntity=Billet::class, mappedBy="coutEvent", orphanRemoval=true)
     */
    private $billets;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbBillet(): ?int
    {
        return $this->NbBillet;
    }

    public function setNbBillet(int $NbBillet): self
    {
        $this->NbBillet = $NbBillet;

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

    public function getCoutcategorie(): ?CoutCategorie
    {
        return $this->coutcategorie;
    }

    public function setCoutcategorie(?CoutCategorie $coutcategorie): self
    {
        $this->coutcategorie = $coutcategorie;

        return $this;
    }

    public function getDemandeEvent(): ?DemandeEvenement
    {
        return $this->demandeEvent;
    }

    public function setDemandeEvent(?DemandeEvenement $demandeEvent): self
    {
        $this->demandeEvent = $demandeEvent;

        return $this;
    }

    /**
     * @return Collection<int, Billet>
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setCoutEvent($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->removeElement($billet)) {
            // set the owning side to null (unless already changed)
            if ($billet->getCoutEvent() === $this) {
                $billet->setCoutEvent(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return "bonjour";
    }
}
