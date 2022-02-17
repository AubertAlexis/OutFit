<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdministratorRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Administrator
{

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="administrator", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    public function __construct()
    {
        $this->id = new UuidV4();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): void
    {
        $this->user->setUpdatedAt();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
