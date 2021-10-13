<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Repository\Order\LineRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=LineRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="order_line")
 */
class Line
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $id;
/**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\Order", inversedBy="lines")
     * @ORM\JoinColumn(nullable=false)
     */
    private Order $order;
/**
     * @ORM\Column(type="integer")
     */
    private int $amount = 0;
/**
     * @ORM\Column(type="integer")
     */
    private int $quantity = 0;
/**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;
/**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $updatedAt;
    public function __construct()
    {
        $this->id = new UuidV4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function decreaseQuantity(): self
    {
        $this->quantity--;
        return $this;
    }

    public function increaseQuantity(): self
    {
        $this->quantity++;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
