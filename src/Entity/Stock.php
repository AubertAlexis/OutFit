<?php

namespace App\Entity;

use App\Repository\StockRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $id;

    /**
     * @ORM\ManyToOne(targetEntity=Size::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Size $size;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Color $color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $quantity;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $enabled;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="stocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private Product $product;

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

    public function getSize(): Size
    {
        return $this->size;
    }

    public function setSize(Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function setColor(Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
