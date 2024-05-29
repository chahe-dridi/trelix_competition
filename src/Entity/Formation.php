<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idFormation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idformation;

    /**
     * @var string
     *
     * @ORM\Column(name="titreFormation", type="string", length=30, nullable=false)
     */
    private $titreformation;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionFormation", type="string", length=100, nullable=false)
     */
    private $descriptionformation;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=200, nullable=false)
     */
    private $photo;

    public function getIdformation(): ?int
    {
        return $this->idformation;
    }

    public function getTitreformation(): ?string
    {
        return $this->titreformation;
    }

    public function setTitreformation(string $titreformation): static
    {
        $this->titreformation = $titreformation;

        return $this;
    }

    public function getDescriptionformation(): ?string
    {
        return $this->descriptionformation;
    }

    public function setDescriptionformation(string $descriptionformation): static
    {
        $this->descriptionformation = $descriptionformation;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }


}
