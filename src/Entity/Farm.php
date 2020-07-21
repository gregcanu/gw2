<?php

namespace App\Entity;

use App\Repository\FarmRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FarmRepository::class)
 */
class Farm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="farms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $map;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $waypoint_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $waypoint_code;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sort;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(string $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getWaypointName(): ?string
    {
        return $this->waypoint_name;
    }

    public function setWaypointName(string $waypoint_name): self
    {
        $this->waypoint_name = $waypoint_name;

        return $this;
    }

    public function getWaypointCode(): ?string
    {
        return $this->waypoint_code;
    }

    public function setWaypointCode(string $waypoint_code): self
    {
        $this->waypoint_code = $waypoint_code;

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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
