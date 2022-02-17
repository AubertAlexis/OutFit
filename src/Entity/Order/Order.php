<?php
declare(strict_types=1);

namespace App\Entity\Order;

use App\Entity\Customer;
use App\Entity\Delivery;
use App\Entity\Product;
use App\Repository\Order\OrderRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="`order`")
 */
class Order
{
    const CART = 'cart';
    const PENDING = 'pending';
    const SUCCESS = 'success';
    const REFUSED = 'refused';

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private Customer $customer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $state = self::CART;

    /**
     * @var Collection<int, Line>
     * @ORM\OneToMany(targetEntity="App\Entity\Order\Line", mappedBy="order", cascade={"persist"})
     */
    private Collection $lines;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $stripeId;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=delivery::class, inversedBy="orders")
     */
    private ?Delivery $delivery;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->lines = new ArrayCollection();
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

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, Line>
     */
    public function getLines(): Collection
    {
        return $this->lines;
    }

    public function addProduct(Product $product): self
    {
        $lines = $this->lines->filter(fn (Line $line) => $line->getProduct() === $product);

        $line = $lines->first();

        if ($line === false) {
            $line = new Line();

            $line->setProduct($product)
                ->setOrder($this)
                ->setAmount($product->getPrice());


            $this->lines->add($line);
        }

        $line->increaseQuantity();
        $line->setAmount((float) $line->getQuantity() * $product->getPrice());

        return $this;
    }

    public function decreaseProduct(Product $product): self
    {
        $lines = $this->lines->filter(fn (Line $line) => $line->getProduct() === $product);

        $line = $lines->first();

        if ($line === false) {
            return $this;
        }

        $line->decreaseQuantity();
        $line->setAmount((float) $line->getQuantity() * $product->getPrice());

        return $this;
    }

    /**
     * @param false $cent
     * @return float|int
     */
    public function getTotal($cent = false)
    {
        $total = 0;
        /** @var Line $line */
        foreach ($this->lines as $line) {
            $total += $line->getAmount();
        }
        if ($this->delivery) {
            $total += $this->delivery->getPrice();
        }

        return $cent ? (int) $total * 100 : $total;
    }

    public function getStripeId(): ?string
    {
        return $this->stripeId;
    }

    public function setStripeId(?string $stripeId): self
    {
        $this->stripeId = $stripeId;

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

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }
}
