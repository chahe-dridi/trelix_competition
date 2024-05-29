<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="fk_formation_id", columns={"idFormation"}), @ORM\Index(name="idutilisateur", columns={"idutilisateur"})})
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class Cours
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCours", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcours;

    /**
     * @var string
     *
     * @ORM\Column(name="titreCours", type="string", length=30, nullable=false)
     */
    private $titrecours;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionCours", type="string", length=30, nullable=false)
     */
    private $descriptioncours;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=200, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=200, nullable=false)
     */
    private $file;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idutilisateur", referencedColumnName="id")
     * })
     */
    private $idutilisateur;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFormation", referencedColumnName="idFormation")
     * })
     */
    private $idformation;

    public function getIdcours(): ?int
    {
        return $this->idcours;
    }

    public function getTitrecours(): ?string
    {
        return $this->titrecours;
    }

    public function setTitrecours(string $titrecours): static
    {
        $this->titrecours = $titrecours;

        return $this;
    }

    public function getDescriptioncours(): ?string
    {
        return $this->descriptioncours;
    }

    public function setDescriptioncours(string $descriptioncours): static
    {
        $this->descriptioncours = $descriptioncours;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getIdutilisateur(): ?Utilisateur
    {
        return $this->idutilisateur;
    }

    public function setIdutilisateur(?Utilisateur $idutilisateur): static
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    public function getIdformation(): ?Formation
    {
        return $this->idformation;
    }

    public function setIdformation(?Formation $idformation): static
    {
        $this->idformation = $idformation;

        return $this;
    }


}
