<?php

declare(strict_types=1);

namespace App\Domain\Entity\Article;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'articles')]
class Article
{
    #[ORM\Id, ORM\Column(type: 'integer', options: ['unsigned' => true]), ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $title;

    #[ORM\Column(type: 'string', unique: true)]
    private string $slug;

    #[ORM\Column(type: 'boolean', options: ['default' => 1])]
    private bool $isActive;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $views;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct(
        string $title,
        string $slug,
        string $description,
        bool $isActive = true,
        int $views = 0,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->isActive = $isActive;
        $this->views = $views;
        $this->createdAt = $createdAt ?: new DateTimeImmutable();
    }

    public function edit(string $title, string $slug, string $description, bool $isActive, int $views): self
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->isActive = $isActive;
        $this->views = $views;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
