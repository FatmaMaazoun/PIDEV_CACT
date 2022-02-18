<?php

namespace App\Entity;

use App\Repository\BilletRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BilletRepository::class)
 */
class Billet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_billet;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="billets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;

    /**
     * @ORM\ManyToOne(targetEntity=CoutEvenement::class, inversedBy="billets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coutEvent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreBillet(): ?int
    {
        return $this->nombre_billet;
    }

    public function setNombreBillet(int $nombre_billet): self
    {
        $this->nombre_billet = $nombre_billet;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getCoutEvent(): ?CoutEvenement
    {
        return $this->coutEvent;
    }

    public function setCoutEvent(?CoutEvenement $coutEvent): self
    {
        $this->coutEvent = $coutEvent;

        return $this;
    }
}
