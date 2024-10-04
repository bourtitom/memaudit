<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?bool $type_partie = null;

    #[ORM\Column]
    private ?int $theme = null;

    #[ORM\Column]
    private ?int $score = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function isTypePartie(): ?bool
    {
        return $this->type_partie;
    }

    public function setTypePartie(bool $type_partie): static
    {
        $this->type_partie = $type_partie;

        return $this;
    }


    public function getTheme(): ?int
    {
        return $this->theme;
    }

    public function setTheme(int $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }
}
