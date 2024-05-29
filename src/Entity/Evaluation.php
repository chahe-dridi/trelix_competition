<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation", indexes={@ORM\Index(name="idcour", columns={"idutilisateur", "idcour"}), @ORM\Index(name="idcour_2", columns={"idcour"}), @ORM\Index(name="IDX_1323A575DBDD131C", columns={"idutilisateur"})})
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationRepository")
 */
class Evaluation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="NoteF", type="integer", nullable=false)
     */
    private $notef;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=30, nullable=false)
     */
    private $description;

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
     * @var \Cours
     *
     * @ORM\ManyToOne(targetEntity="Cours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcour", referencedColumnName="idCours")
     * })
     */
    private $idcour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getNotef(): ?int
    {
        return $this->notef;
    }

    public function setNotef(int $notef): static
    {
        $this->notef = $notef;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getIdcour(): ?Cours
    {
        return $this->idcour;
    }

    public function setIdcour(?Cours $idcour): static
    {
        $this->idcour = $idcour;

        return $this;
    }


}
