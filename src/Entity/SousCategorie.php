<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 */
class SousCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("sous categorie")

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 15,
     *      minMessage = " la libelle doit avoir au minimum  {{ limit }} caractéres ",
     *      maxMessage = " la libelle doit avoir au maximum {{ limit }} caractéres"
     * )
     */
    private $libelle;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      max = 300,
     *      minMessage = " la description doit avoir au minimum  {{ limit }} caractéres ",
     *      maxMessage = " la description doit avoir au maximum {{ limit }} caractéres"
     * )
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="sousCategories")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Destination::class, mappedBy="souscategorie", orphanRemoval=true)
     */
    private $destinations;

    /**
     * @ORM\ManyToOne(targetEntity=CouleurEvenement::class, inversedBy="sousCategories")
     */
    private $CouleurEvenement;

    public function __construct()
    {
        $this->destinations = new ArrayCollection();
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Destination>
     */
    public function getDestinations(): Collection
    {
        return $this->destinations;
    }

    public function addDestination(Destination $destination): self
    {
        if (!$this->destinations->contains($destination)) {
            $this->destinations[] = $destination;
            $destination->setSouscategorie($this);
        }

        return $this;
    }

    public function removeDestination(Destination $destination): self
    {
        if ($this->destinations->removeElement($destination)) {
            // set the owning side to null (unless already changed)
            if ($destination->getSouscategorie() === $this) {
                $destination->setSouscategorie(null);
            }
        }

        return $this;
    }

    public function getCouleurEvenement(): ?CouleurEvenement
    {
        return $this->CouleurEvenement;
    }

    public function setCouleurEvenement(?CouleurEvenement $CouleurEvenement): self
    {
        $this->CouleurEvenement = $CouleurEvenement;

        return $this;
    }
}
