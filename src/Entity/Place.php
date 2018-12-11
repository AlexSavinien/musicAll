<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(max="150", maxMessage="Votre nom ne peut pas dépasser {{limit}} caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     * @Assert\Length(max="250", maxMessage="Votre email ne peut pas dépasser {{limit}} caractères")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="places")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $owner;


    /**
     * @ORM\Column(type="integer", length=5)
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(max="5", maxMessage="Le numéro de la rue ne peut pas dépasser {{limit}} caractères")
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(max="250", maxMessage="La nom de la rue ne peut pas dépasser {{limit}} caractères")
     */
    private $streetName;


    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(
     *     max="5",
     *     min="5",
     *     maxMessage="Le code postal ne doit pas dépasser {{limit}} caractère",
     *     minMessage="Le code postal ne doit pas faire moins de {{limit}} caractère")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Champ obligatoire")
     *
     */
    private $lon;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $lat;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="place")
     */
    private $events;


    public function __construct()
    {
        $this->events = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress(): ?string
    {
        return $this->streetNumber ." ". $this->streetName;
    }

    /**
     * @return mixed
     */
    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     * @return Place
     */
    public function setZipCode($zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLon(): ?float
    {
        return $this->lon;
    }

    /**
     * @param mixed $lon
     * @return Place
     */
    public function setLon($lon): self
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     * @return Place
     */
    public function setLat($lat): self
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setPlace($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getPlace() === $this) {
                $event->setPlace(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreetNumber(): ?float
    {
        return $this->streetNumber;
    }

    /**
     * @param mixed $streetNumber
     * @return Place
     */
    public function setStreetNumber($streetNumber): self
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    /**
     * @param mixed $streetName
     * @return Place
     */
    public function setStreetName($streetName): self
    {
        $this->streetName = $streetName;
        return $this;
    }

}
