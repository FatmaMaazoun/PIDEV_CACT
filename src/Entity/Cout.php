<?php

namespace App\Entity;

use App\Repository\CoutRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoutRepository::class)
 */
class Cout
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Destination::class, inversedBy="couts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity=CoutCategorie::class, inversedBy="couts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coutcategorie;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCoutcategorie(): ?CoutCategorie
    {
        return $this->coutcategorie;
    }

    public function setCoutcategorie(?CoutCategorie $coutcategorie): self
    {
        $this->coutcategorie = $coutcategorie;

        return $this;
    }
}
