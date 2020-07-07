<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BeerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"beer:read"}},
 *  denormalizationContext={"groups"={"beer:write"}}
 * )
 * @ORM\Entity(repositoryClass=BeerRepository::class)
 * @UniqueEntity(fields="name", message="Name is already taken.")
 */
class Beer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"beer:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"beer:read", "beer:write"})
     * @Assert\Length(min = 3, max = 255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * Groups({"beer:read", "beer:write"})
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     */
    private $abv;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"beer:read", "beer:write"})
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     */
    private $ibu;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"beer:read", "beer:write"})
     * @Assert\NotBlank
     * @Assert\DateTime(
     *      message="Invalid format of date_create"
     * )
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"beer:read", "beer:write"})
     * @Assert\NotBlank
     * @Assert\DateTime(
     *      message="Invalid format of date_update"
     * )
     */
    private $dateUpdate;

    /**
     * @ORM\OneToMany(targetEntity=Checkin::class, mappedBy="beer", orphanRemoval=true)
     */
    private $checkins;

    /**
     * @ORM\ManyToOne(targetEntity=Brasserie::class, inversedBy="beers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"beer:read", "beer:write"})
     */
    private $brasserie;

    public function __construct()
    {
        $this->brasserie = new ArrayCollection();
        $this->checkins = new ArrayCollection();
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

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(float $abv): self
    {
        $this->abv = $abv;

        return $this;
    }

    public function getIbu(): ?int
    {
        return $this->ibu;
    }

    public function setIbu(int $ibu): self
    {
        $this->ibu = $ibu;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * @return Collection|Checkin[]
     */
    public function getCheckins(): Collection
    {
        return $this->checkins;
    }

    public function addCheckin(Checkin $checkin): self
    {
        if (!$this->checkins->contains($checkin)) {
            $this->checkins[] = $checkin;
            $checkin->setBeer($this);
        }

        return $this;
    }

    public function removeCheckin(Checkin $checkin): self
    {
        if ($this->checkins->contains($checkin)) {
            $this->checkins->removeElement($checkin);
            // set the owning side to null (unless already changed)
            if ($checkin->getBeer() === $this) {
                $checkin->setBeer(null);
            }
        }

        return $this;
    }

    public function getBrasserie(): ?Brasserie
    {
        return $this->brasserie;
    }

    public function setBrasserie(?Brasserie $brasserie): self
    {
        $this->brasserie = $brasserie;

        return $this;
    }
}
