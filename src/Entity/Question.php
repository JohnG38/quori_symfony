<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir un titre.")]
    #[Assert\Length(min: 20, minMessage: "Veuillez détailler votre titre.", max: 255, maxMessage: "Votre titre est trop long.")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Veuillez saisir une question.")]
    #[Assert\Length(min: 20, minMessage: "Veuillez détailler votre question.")]

    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column]
    private ?int $nbResponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getNbResponse(): ?int
    {
        return $this->nbResponse;
    }

    public function setNbResponse(int $nbResponse): self
    {
        $this->nbResponse = $nbResponse;

        return $this;
    }
}
