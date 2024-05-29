<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
 * @ORM\Entity(repositoryClass="App\Repository\AbonnementRepository")
 */
class Abonnement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAbonnement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idabonnement;

    /**
     * @var string
     *
     * @ORM\Column(name="DateDebut", type="string", length=50, nullable=false)
     */
    private $datedebut;

    /**
     * @var string
     *
     * @ORM\Column(name="DateFin", type="string", length=50, nullable=false)
     */
    private $datefin;

    /**
     * @var float
     *
     * @ORM\Column(name="PRIX_PAR_DUREE", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixParDuree;

    /**
     * @var string
     *
     * @ORM\Column(name="NomAbonnement", type="string", length=50, nullable=false)
     */
    private $nomabonnement;

    /**
     * @var string
     *
     * @ORM\Column(name="Duree", type="string", length=50, nullable=false)
     */
    private $duree;

    public function getIdabonnement(): ?int
    {
        return $this->idabonnement;
    }

    public function getDatedebut(): ?string
    {
        return $this->datedebut;
    }

    public function setDatedebut(string $datedebut): static
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?string
    {
        return $this->datefin;
    }

    public function setDatefin(string $datefin): static
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getPrixParDuree(): ?float
    {
        return $this->prixParDuree;
    }

    public function setPrixParDuree(float $prixParDuree): static
    {
        $this->prixParDuree = $prixParDuree;

        return $this;
    }

    public function getNomabonnement(): ?string
    {
        return $this->nomabonnement;
    }

    public function setNomabonnement(string $nomabonnement): static
    {
        $this->nomabonnement = $nomabonnement;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }


}
