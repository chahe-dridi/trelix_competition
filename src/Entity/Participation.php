<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idCompetition", columns={"idCompetition"})})
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    #[Assert\NotBlank(message: "your solution should not be empty")]
    /**
     * @var string|null
     *
     * @ORM\Column(name="urlSolution", type="string", length=255, nullable=true)
     */
    private $urlsolution;

    #[Assert\NotBlank(message: "idUser should not be empty")]
    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    #[Assert\NotBlank(message: "idCompetition should not be empty")]
    /**
     * @var \Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCompetition", referencedColumnName="id")
     * })
     */
    private $idcompetition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlsolution(): ?string
    {
        return $this->urlsolution;
    }

    public function setUrlsolution(?string $urlsolution): static
    {
        $this->urlsolution = $urlsolution;

        return $this;
    }

    public function getIduser(): ?Utilisateur
    {
        return $this->iduser;
    }

    public function setIduser(?Utilisateur $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdcompetition(): ?Competition
    {
        return $this->idcompetition;
    }

    public function setIdcompetition(?Competition $idcompetition): static
    {
        $this->idcompetition = $idcompetition;

        return $this;
    }

    public function __toString(): string
    {
        // Retourne une représentation string de l'objet, par exemple le nom de l'aéroport
        return $this->id;
    }

}
