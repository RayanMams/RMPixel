<?php 

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Indique à Doctrine que cette classe correspond à une table
#[ORM\Entity]
class Game
{
    #[ORM\Id] // Clé primaire
    #[ORM\GeneratedValue] // Auto increment
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $description;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private \DateTime|null $releaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Name $category = null;

    #[ORM\Column(length: 255)]
    private ?string $Support = null;

    public function getId(): int|null
    {
        return $this->id;
    }
 
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): null|string
    {
        return $this->description;
    }

    public function setDescription(null|string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): \DateTime|null
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime|null $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCategory(): ?Name
    {
        return $this->category;
    }

    public function setCategory(?Name $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->Support;
    }

    public function setSupport(string $Support): static
    {
        $this->Support = $Support;

        return $this;
    }
}