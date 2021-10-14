<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

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
     * @ORM\Embedded(class="User")
     */
    private User $user;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->user = new User();
        $this->user->setRoles([User::ROLE_ADMINISTRATOR]);
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): void
    {
        $this->user->setUpdatedAt(new DateTimeImmutable());
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Administrator
    {
        $this->user = $user;
        return $this;
    }
}
