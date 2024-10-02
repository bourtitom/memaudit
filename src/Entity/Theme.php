<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $type = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function isType(): ?bool
    {
        return $this->type;
    }
    public function setType(bool $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
