<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("utilisateur")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("utilisateur")
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("utilisateur")
     *
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     * @Groups("utilisateur")
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("utilisateur")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("utilisateur")
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     * @Groups("utilisateur")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank(message="Email est obligatoire")
     * ** @Assert\Email(message = "The email '{{ value }}' est invalide email.")
     * @Groups("utilisateur")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Groups("utilisateur")
     */
    private $num_tel;

    /**
     * @ORM\OneToMany(targetEntity=Destination::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $destinations;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=DemandeEvenement::class, mappedBy="utilisateur")
     */
    private $demandeEvenements;

    public function __construct()
    {
        $this->destinations = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->demandeEvenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

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

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    /**
     * @return Collection<int, Destination>
     */
    public function getDestinations(): Collection
    {
        return $this->destinations;
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
            $avi->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUtilisateur() === $this) {
                $avi->setUtilisateur(null);
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
            $reservation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUtilisateur() === $this) {
                $reservation->setUtilisateur(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->login;
    }

    /**
     * @return Collection<int, DemandeEvenement>
     */
    public function getDemandeEvenements(): Collection
    {
        return $this->demandeEvenements;
    }

    public function addDemandeEvenement(DemandeEvenement $demandeEvenement): self
    {
        if (!$this->demandeEvenements->contains($demandeEvenement)) {
            $this->demandeEvenements[] = $demandeEvenement;
            $demandeEvenement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDemandeEvenement(DemandeEvenement $demandeEvenement): self
    {
        if ($this->demandeEvenements->removeElement($demandeEvenement)) {
            // set the owning side to null (unless already changed)
            if ($demandeEvenement->getUtilisateur() === $this) {
                $demandeEvenement->setUtilisateur(null);
            }
        }

        return $this;
    }
}
