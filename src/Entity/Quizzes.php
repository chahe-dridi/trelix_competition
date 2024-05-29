<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quizzes
 *
 * @ORM\Table(name="quizzes")
 * @ORM\Entity(repositoryClass="App\Repository\QuizzesRepository")
 */
class Quizzes
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
     * @var string
     *
     * @ORM\Column(name="quiz_data", type="string", length=200, nullable=false)
     */
    private $quizData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizData(): ?string
    {
        return $this->quizData;
    }

    public function setQuizData(string $quizData): static
    {
        $this->quizData = $quizData;

        return $this;
    }


}
