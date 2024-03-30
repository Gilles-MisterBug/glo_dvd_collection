<?php

namespace App\Entity;

use App\Repository\ImportMovieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ImportMovieRepository::class)]
#[ORM\Table(name: 'import_movie')]
class ImportMovie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movies.list', 'movies.detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['movies.list', 'movies.detail'])]
    private ?string $support = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ref = null;

    #[ORM\Column(length: 500)]
    #[Groups(['movies.list', 'movies.detail'])]
    private ?string $title = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Groups(['movies.list', 'movies.detail'])]
    private ?string $originalTitle = null;

    #[ORM\Column(length: 4000, nullable: true)]
    #[Groups(['movies.detail'])]
    private ?string $synopsis = null;

    #[ORM\Column(nullable: true)]
    private ?int $tmdbId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(?string $support): static
    {
        $this->support = $support;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): static
    {
        $this->ref = $ref;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(?string $originalTitle): static
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(?int $tmdbId): static
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }
}
