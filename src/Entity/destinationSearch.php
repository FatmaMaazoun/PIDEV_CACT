<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class destinationSearch
{
    /**
     *  @var string| null
     */
    private $name;


    /**
     *  @return string| null
     */
    public function getName(): ?string
    {
        return $this->name;;
    }

    /**
     *  @param string| null $name
     *  @return destinationSearch
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }


    /**
     *  @var int| null
     */
    private $prix;


    /**
     *  @return int| null
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     *  @param int| null $prix
     *  @return destinationSearch
     */
    public function setPrix(int $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * @var Gouvernorat[]
     */
    public $gouvernorat = [];
}
