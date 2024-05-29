<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vote
 *
 * @ORM\Table(name="vote", indexes={@ORM\Index(name="idUtilisateur", columns={"idUtilisateur"}), @ORM\Index(name="idParticipation", columns={"idParticipation"})})
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    #[Assert\NotBlank(message: "note should not be empty")]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d+)?$/',
        message: "Price should be a valid number"
    )]
    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    #[Assert\NotBlank(message: "idutilisateur should not be empty")]
    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUtilisateur", referencedColumnName="id")
     * })
     */
    private $idutilisateur;

    #[Assert\NotBlank(message: "idparticipation should not be empty")]
    /**
     * @var \Participation
     *
     * @ORM\ManyToOne(targetEntity="Participation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idParticipation", referencedColumnName="id")
     * })
     */
    private $idparticipation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

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

    public function getIdparticipation(): ?Participation
    {
        return $this->idparticipation;
    }

    public function setIdparticipation(?Participation $idparticipation): static
    {
        $this->idparticipation = $idparticipation;

        return $this;
    }



    public function __toString(): string
    {
        // Retourne une représentation string de l'objet, par exemple le nom de l'aéroport
        return $this->id;
    }




}
