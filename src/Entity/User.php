<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"user:read"}},
 *  denormalizationContext={"groups"={"user:write"}},
 *  collectionOperations={
 *      "get"={},
 *      "post"={},
 *      ""
 *  }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="pseudo", message="Pseudo is already taken.")
 */
class User implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=6)
     * @Groups({"user:read", "user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     */
    private $role = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime(
     *      message="Invalid format of date_create"
     * )
     * @Groups({"user:read", "user:write"})
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime(
     *      message="Invalid format of date_update"
     * )
     * @Groups({"user:read", "user:write"})
     */
    private $dateUpdate;

    /**
     * @ORM\OneToMany(targetEntity=Checkin::class, mappedBy="user", orphanRemoval=true)
     */
    private $checkins;

    public function __construct()
    {
        $this->checkins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?array
    {
        $roles = $this->role;
        $roles[] = self::ROLE_USER;

        return $roles;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
            $checkin->setUser($this);
        }

        return $this;
    }

    public function removeCheckin(Checkin $checkin): self
    {
        if ($this->checkins->contains($checkin)) {
            $this->checkins->removeElement($checkin);
            // set the owning side to null (unless already changed)
            if ($checkin->getUser() === $this) {
                $checkin->setUser(null);
            }
        }

        return $this;
    }

    //

    public function getRoles(): array
    {
        return $this->getRole();
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->getPseudo();
    }

    public function eraseCredentials()
    {
        //TODO
    }
}
