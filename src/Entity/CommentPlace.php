<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentPlaceRepository")
 */
class CommentPlace
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous ne pouvez pas envoyer un commentaire vide.")
     * @Assert\Length(max="300", maxMessage="Le commentaire ne doit pas dépasser {{limit}} caractères")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userPlaceComment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="commentsPlace")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }
}
