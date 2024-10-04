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
    private ?int $moove = null;

    #[ORM\Column]
    private ?int $theme = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $type_partie = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;
    

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

    public function getMoove(): ?int
    {
        return $this->moove;
    }

    public function setMoove(int $moove): static
    {
        $this->moove = $moove;

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


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
