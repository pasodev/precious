<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductStoreRepository")
 */
class ProductStore
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @ORM\Column(type="integer")
     */
    private $StoreId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lastPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $bestPrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastPriceDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bestPriceDate;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStoreId(): ?int
    {
        return $this->StoreId;
    }

    public function setStoreId(int $StoreId): self
    {
        $this->StoreId = $StoreId;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getLastPrice(): ?int
    {
        return $this->lastPrice;
    }

    public function setLastPrice(?int $lastPrice): self
    {
        $this->lastPrice = $lastPrice;

        return $this;
    }

    public function getBestPrice(): ?int
    {
        return $this->bestPrice;
    }

    public function setBestPrice(int $bestPrice): self
    {
        $this->bestPrice = $bestPrice;

        return $this;
    }

    public function getLastPriceDate(): ?\DateTimeInterface
    {
        return $this->lastPriceDate;
    }

    public function setLastPriceDate(\DateTimeInterface $lastPriceDate): self
    {
        $this->lastPriceDate = $lastPriceDate;

        return $this;
    }

    public function getBestPriceDate(): ?\DateTimeInterface
    {
        return $this->bestPriceDate;
    }

    public function setBestPriceDate(\DateTimeInterface $bestPriceDate): self
    {
        $this->bestPriceDate = $bestPriceDate;

        return $this;
    }
}
