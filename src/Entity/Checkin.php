<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CheckinRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"checkin:read"}},
 *  denormalizationContext={"groups"={"checkin:write"}}
 * )
 * @ORM\Entity(repositoryClass=CheckinRepository::class)
 */
class Checkin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"checkin:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min = 0, max = 10)
     * @Assert\NotBlank
     * @Groups({"checkin:read", "checkin:write"})
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity=Beer::class, inversedBy="checkins")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups({"checkin:read", "checkin:write"})
     */
    private $beer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="checkins")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups({"checkin:read", "checkin:write"})
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime(
     *      message="Invalid format of date_create"
     * )
     * @Groups({"checkin:read", "checkin:write"})
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime(
     *      message="Invalid format of date_update"
     * )
     * @Groups({"checkin:read", "checkin:write"})
     */
    private $dateUpdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?float
    {
        return $this->mark;
    }

    public function setMark(float $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getBeer(): ?Beer
    {
        return $this->beer;
    }

    public function setBeer(?Beer $beer): self
    {
        $this->beer = $beer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
