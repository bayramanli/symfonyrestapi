<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ordersCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $shippingDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdersCode(): ?string
    {
        return $this->ordersCode;
    }

    public function setOrdersCode(string $ordersCode): self
    {
        $this->ordersCode = $ordersCode;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    public function setShippingDate(string $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'ordersCode' => $this->getOrdersCode(),
            'productId' => $this->getProductId(),
            'quantity' => $this->getQuantity(),
            'address' => $this->getAddress(),
            'shippingDate' => $this->getShippingDate(),
        ];
    }
}