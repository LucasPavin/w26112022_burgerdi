<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $calorie = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?agency $id_agency = null;

    #[ORM\ManyToMany(targetEntity: Vote::class, mappedBy: 'id_meal')]
    private Collection $id_meal;

    #[ORM\ManyToMany(targetEntity: category::class)]
    private Collection $id_category;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    public function __construct()
    {
        $this->id_meal = new ArrayCollection();
        $this->id_category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    public function setCalorie(int $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }

    public function getIdAgency(): ?agency
    {
        return $this->id_agency;
    }

    public function setIdAgency(?agency $id_agency): self
    {
        $this->id_agency = $id_agency;

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getIdMeal(): Collection
    {
        return $this->id_meal;
    }

    public function addIdMeal(Vote $idMeal): self
    {
        if (!$this->id_meal->contains($idMeal)) {
            $this->id_meal->add($idMeal);
            $idMeal->addIdMeal($this);
        }

        return $this;
    }

    public function removeIdMeal(Vote $idMeal): self
    {
        if ($this->id_meal->removeElement($idMeal)) {
            $idMeal->removeIdMeal($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getIdCategory(): Collection
    {
        return $this->id_category;
    }

    public function addIdCategory(category $idCategory): self
    {
        if (!$this->id_category->contains($idCategory)) {
            $this->id_category->add($idCategory);
        }

        return $this;
    }

    public function removeIdCategory(category $idCategory): self
    {
        $this->id_category->removeElement($idCategory);

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }
}
