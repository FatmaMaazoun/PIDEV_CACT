<?php

namespace App\Entity;

use App\Repository\DestinationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DestinationRepository::class)
 */
class Destination
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Demande_des;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class, inversedBy="destinations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $souscategorie;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="destinations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=CoutCategorie::class, mappedBy="destination", orphanRemoval=true)
     */
    private $coutCategories;



    /**
     * @ORM\OneToMany(targetEntity=Cout::class, mappedBy="destination", orphanRemoval=true)
     */
    private $couts;


     /**
     * @ORM\OneToMany(targetEntity=CoutCategorie::class, mappedBy="destination", orphanRemoval=true)
     */
    private $DemandeEvenements;
   

    public function __construct()
    {
        $this->coutCategories = new ArrayCollection();


        $this->couts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDemandeDes(): ?\DateTimeInterface
    {
        return $this->Date_Demande_des;
    }

    public function setDateDemandeDes(\DateTimeInterface $Date_Demande_des): self
    {
        $this->Date_Demande_des = $Date_Demande_des;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSouscategorie(): ?SousCategorie
    {
        return $this->souscategorie;
    }

    public function setSouscategorie(?SousCategorie $souscategorie): self
    {
        $this->souscategorie = $souscategorie;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }



    /**
     * @return Collection<int, CoutCategorie>
     */
    public function getCoutCategories(): Collection
    {
        return $this->coutCategories;
    }

    public function addCoutCategory(CoutCategorie $coutCategory): self
    {
        if (!$this->coutCategories->contains($coutCategory)) {
            $this->coutCategories[] = $coutCategory;
            $coutCategory->setDestination($this);
        }

        return $this;
    }

    public function removeCoutCategory(CoutCategorie $coutCategory): self
    {
        if ($this->coutCategories->removeElement($coutCategory)) {
            // set the owning side to null (unless already changed)
            if ($coutCategory->getDestination() === $this) {
                $coutCategory->setDestination(null);
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

    public function addCout(Cout $cout): self
    {
        if (!$this->couts->contains($cout)) {
            $this->couts[] = $cout;
            $cout->setDestination($this);
        }

        return $this;
    }

    public function removeCout(Cout $cout): self
    {
        if ($this->couts->removeElement($cout)) {
            // set the owning side to null (unless already changed)
            if ($cout->getDestination() === $this) {
                $cout->setDestination(null);
            }
        }

        return $this;
    }

 /**
     * @return Collection|DemandeEvenement[]
     */
    public function getDemandeEvenements(): Collection
    {
        return $this->DemandeEvenements;
    }

    public function addDemandeEvenement(DemandeEvenement $demandeEvenement): self
    {
        if (!$this->demandeEvenements->contains($demandeEvenement)) {
            $this->demandeEvenements[] = $demandeEvenement;
            $demandeEvenement->setDestination($this);
        }

        return $this;
    }

    public function removeDemandeEvenement(DemandeEvenement $demandeEvenement): self
    {
        if ($this->demandeEvenements->removeElement($demandeEvenement)) {
            // set the owning side to null (unless already changed)
            if ($DemandeEvenement->getDemandeEvenement() === $this) {
                $demandeEvenement->setDestination(null);
            }
        }

        return $this;
    }



    public function getDelegation(): ?Delegation
    {
        return $this->delegation;
    }

    public function setDelegation(?Delegation $delegation): self
    {
        $this->delegation = $delegation;

        return $this;
    }
}
