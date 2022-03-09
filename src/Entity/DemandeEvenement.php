<?php

namespace App\Entity;

use App\Repository\DemandeEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DemandeEvenementRepository::class)
 */
class DemandeEvenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("demandeEvenement")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups("demandeEvenement")
     */
    private $date_demande;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("demandeEvenement")
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="30",maxMessage="votre description doit contenir au maximun 30 caracteres")
     * @Assert\NotBlank(message="le champ description de demande est obligatoire")
     * @Groups("demandeEvenement")
     */
    private $description_demande;

    /**
     * @ORM\Column(type="date")
     * @Groups("demandeEvenement")
     * 
     */
    private $date_debutEvent;

    /**
     * @ORM\Column(type="date")
     * @Groups("demandeEvenement")
     */
    private $date_finEvent;

    /**
     * @ORM\Column(type="time")
     * @Groups("demandeEvenement")
     */
    private $heure_debutEvent;

    /**
     * @ORM\Column(type="time")
     * @Groups("demandeEvenement")
     */
    private $heure_finEvent;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="30",maxMessage="votre description doit contenir au maximun 30 caracteres")
     * @Assert\NotBlank(message="le champ description d'evenement est obligatoire")
     * @Groups("demandeEvenement")
     */
    private $description_event;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\NotBlank(message="le champ description d'evenement est obligatoire")
     * @Groups("demandeEvenement")
     */
    private $capacite;

    /**
     * @ORM\ManyToOne(targetEntity=Destination::class, inversedBy="demandeEvenements")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("demandeEvenement")
     */
    private $destination;

    /**
     * @ORM\OneToMany(targetEntity=CoutEvenement::class, mappedBy="demandeEvent", orphanRemoval=true)
     */
    private $coutEvenements;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="demandeEvent", orphanRemoval=true)
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="demandeEvent", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champ nom de l'evenement est obligatoire")
     */
    private $libelleEvenement;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\NotBlank(message="l'image est obligatoire")
      *@Groups("demandeEvenement")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="demandeEvenements")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("demandeEvenement")
     */
    private $utilisateur;

   

    public function __construct()
    {
        $this->coutEvenements = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->date_demande;
    }

    public function setDateDemande(\DateTimeInterface $date_demande): self
    {
        $this->date_demande = $date_demande;

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

    public function getDescriptionDemande(): ?string
    {
        return $this->description_demande;
    }

    public function setDescriptionDemande(string $description_demande): self
    {
        $this->description_demande = $description_demande;

        return $this;
    }

    public function getDateDebutEvent(): ?\DateTimeInterface
    {
        return $this->date_debutEvent;
    }

    public function setDateDebutEvent(\DateTimeInterface $date_debutEvent): self
    {
        $this->date_debutEvent = $date_debutEvent;

        return $this;
    }

    public function getDateFinEvent(): ?\DateTimeInterface
    {
        return $this->date_finEvent;
    }

    public function setDateFinEvent(\DateTimeInterface $date_finEvent): self
    {
        $this->date_finEvent = $date_finEvent;

        return $this;
    }

    public function getHeureDebutEvent(): ?\DateTimeInterface
    {
        return $this->heure_debutEvent;
    }

    public function setHeureDebutEvent(\DateTimeInterface $heure_debutEvent): self
    {
        $this->heure_debutEvent = $heure_debutEvent;

        return $this;
    }

    public function getHeureFinEvent(): ?\DateTimeInterface
    {
        return $this->heure_finEvent;
    }

    public function setHeureFinEvent(\DateTimeInterface $heure_finEvent): self
    {
        $this->heure_finEvent = $heure_finEvent;

        return $this;
    }

    public function getDescriptionEvent(): ?string
    {
        return $this->description_event;
    }

    public function setDescriptionEvent(string $description_event): self
    {
        $this->description_event = $description_event;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

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
            $coutEvenement->setDemandeEvent($this);
        }

        return $this;
    }

    public function removeCoutEvenement(CoutEvenement $coutEvenement): self
    {
        if ($this->coutEvenements->removeElement($coutEvenement)) {
            // set the owning side to null (unless already changed)
            if ($coutEvenement->getDemandeEvent() === $this) {
                $coutEvenement->setDemandeEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setDemandeEvent($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getDemandeEvent() === $this) {
                $avi->setDemandeEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setDemandeEvent($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getDemandeEvent() === $this) {
                $reservation->setDemandeEvent(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->statut;
    }

    public function getLibelleEvenement(): ?string
    {
        return $this->libelleEvenement;
    }

    public function setLibelleEvenement(string $libelleEvenement): self
    {
        $this->libelleEvenement = $libelleEvenement;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

}
