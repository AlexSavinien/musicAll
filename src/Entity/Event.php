<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $eventDate;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlEvent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlTicketing;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentEvent", mappedBy="event", orphanRemoval=true)
     */
    private $commentsEvent;


    public function __construct()
    {
        $this->commentEvents = new ArrayCollection();
        $this->commentsEvent = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {

        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUrlEvent(): ?string
    {
        return $this->urlEvent;
    }

    public function setUrlEvent(?string $urlEvent): self
    {
        $this->urlEvent = $urlEvent;

        return $this;
    }

    public function getUrlTicketing(): ?string
    {
        return $this->urlTicketing;
    }

    public function setUrlTicketing(?string $urlTicketing): self
    {
        $this->urlTicketing = $urlTicketing;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPlace(): ?place
    {
        return $this->place;
    }

    public function setPlace(?place $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection|CommentEvent[]
     */
    public function getCommentEvents(): Collection
    {
        return $this->commentEvents;
    }

    public function addCommentEvent(CommentEvent $commentEvent): self
    {
        if (!$this->commentEvents->contains($commentEvent)) {
            $this->commentEvents[] = $commentEvent;
            $commentEvent->setUser($this);
        }

        return $this;
    }

    public function removeCommentEvent(CommentEvent $commentEvent): self
    {
        if ($this->commentEvents->contains($commentEvent)) {
            $this->commentEvents->removeElement($commentEvent);
            // set the owning side to null (unless already changed)
            if ($commentEvent->getUser() === $this) {
                $commentEvent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentEvent[]
     */
    public function getCommentsEvent(): Collection
    {
        return $this->commentsEvent;
    }

    public function addCommentsEvent(CommentEvent $commentsEvent): self
    {
        if (!$this->commentsEvent->contains($commentsEvent)) {
            $this->commentsEvent[] = $commentsEvent;
            $commentsEvent->setEvent($this);
        }

        return $this;
    }

    public function removeCommentsEvent(CommentEvent $commentsEvent): self
    {
        if ($this->commentsEvent->contains($commentsEvent)) {
            $this->commentsEvent->removeElement($commentsEvent);
            // set the owning side to null (unless already changed)
            if ($commentsEvent->getEvent() === $this) {
                $commentsEvent->setEvent(null);
            }
        }

        return $this;
    }


}
