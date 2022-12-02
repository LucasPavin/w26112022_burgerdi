<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{ 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Meal::class,  mappedBy:'id_category')]
    private Collection $id_meal;

    public function __construct()
    {
        $this->id_meal = new ArrayCollection();
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

    /**
     * @return Collection<int, meal>
     */
    public function getIdMeal(): Collection
    {
        return $this->id_meal;
    }

    public function addIdMeal(Meal $idMeal): self
    {
        if (!$this->id_meal->contains($idMeal)) {
            $this->id_meal[] = $idMeal;
            $idMeal->addIdCategory($this);
        }

        return $this;
    }

    public function removeIdMeal(Meal $idMeal): self
    {
        // If id_meal contains id_category then we delete it
        if ($this->id_meal->contains($idMeal)) {
            $this->id_meal->removeElement($idMeal);
            $idMeal->removeIdCategory($this);
        }
        // $this->id_meal->removeElement($idMeal);

        return $this;
    }
}
