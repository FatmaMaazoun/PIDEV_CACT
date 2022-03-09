<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\DestinationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\DestinationRepository::class)
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 1500,
     *      minMessage = " la description doit avoir au minimum  {{ limit }} caractéres ",
     *      maxMessage = " la description doit avoir au maximum {{ limit }} caractéres"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex( pattern = "/^[a-zA-Z]+/",message="le nom doit commencer par des lettres ")
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="l'image est obligatoire")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex( pattern = "/^[0-9][0-9], rue [a-zA-Z]/",message="Exemple d'adresse: 14, rue aghleb tamimi ")
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="l'email est obligatoire")
     * @Assert\Email(message = "L'email '{{ value }}' n'est pas valide.") 
     */
    private $email;




    /**
     * @ORM\ManyToOne(targetEntity=Delegation::class, inversedBy="destinations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $delegation;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class, inversedBy="destinations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $souscategorie;

    /**
     * @ORM\OneToMany(targetEntity=Cout::class, mappedBy="destination")
     */
    private $couts;

    public function __construct()
    {
        $this->couts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
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
        return $this->numTel;
    }

    public function setNumTel(int $numTel): self
    {
        $this->numTel = $numTel;

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



    public function getDelegation(): ?Delegation
    {
        return $this->delegation;
    }

    public function setDelegation(?Delegation $delegation): self
    {
        $this->delegation = $delegation;

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
}
