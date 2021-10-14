<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private Customer $customer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $zip;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $selected;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $enabled;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->createdAt = new DateTimeImmutable();
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getSelected(): bool
    {
        return $this->selected;
    }

    public function setSelected(bool $selected): self
    {
        $this->selected = $selected;

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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
