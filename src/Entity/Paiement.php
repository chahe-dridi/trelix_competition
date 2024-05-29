<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement", indexes={@ORM\Index(name="fk_code", columns={"id_code"}), @ORM\Index(name="fk_paiement_utilisateur", columns={"id_utilisateur"}), @ORM\Index(name="fk_paiement_abonnement", columns={"id_abonnement"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaiementRepository")
 */
class Paiement
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DatePaiement", type="date", nullable=false)
     */
    private $datepaiement;

    /**
     * @var int
     *
     * @ORM\Column(name="NumTel", type="integer", nullable=false)
     */
    private $numtel;

    /**
     * @var string
     *
     * @ORM\Column(name="TypePaiement", type="string", length=50, nullable=false)
     */
    private $typepaiement;

    /**
     * @var int
     *
     * @ORM\Column(name="id_abonnement", type="integer", nullable=false)
     */
    private $idAbonnement;

    /**
     * @var \Abonnement
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Abonnement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPaiement", referencedColumnName="idAbonnement")
     * })
     */
    private $idpaiement;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @var \Code
     *
     * @ORM\ManyToOne(targetEntity="Code")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_code", referencedColumnName="id")
     * })
     */
    private $idCode;

    public function getDatepaiement(): ?\DateTimeInterface
    {
        return $this->datepaiement;
    }

    public function setDatepaiement(\DateTimeInterface $datepaiement): static
    {
        $this->datepaiement = $datepaiement;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getTypepaiement(): ?string
    {
        return $this->typepaiement;
    }

    public function setTypepaiement(string $typepaiement): static
    {
        $this->typepaiement = $typepaiement;

        return $this;
    }

    public function getIdAbonnement(): ?int
    {
        return $this->idAbonnement;
    }

    public function setIdAbonnement(int $idAbonnement): static
    {
        $this->idAbonnement = $idAbonnement;

        return $this;
    }

    public function getIdpaiement(): ?Abonnement
    {
        return $this->idpaiement;
    }

    public function setIdpaiement(?Abonnement $idpaiement): static
    {
        $this->idpaiement = $idpaiement;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIdCode(): ?Code
    {
        return $this->idCode;
    }

    public function setIdCode(?Code $idCode): static
    {
        $this->idCode = $idCode;

        return $this;
    }


}
