<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'id_user')]
    private Collection $id_user;

    #[ORM\ManyToMany(targetEntity: Meal::class, inversedBy: 'id_meal')]
    private Collection $id_meal;

    public function __construct()
    {
        $this->id_user = new ArrayCollection();
        $this->id_meal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        $this->id_user->removeElement($idUser);

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
            $this->id_meal->add($idMeal);
        }

        return $this;
    }

    public function removeIdMeal(Meal $idMeal): self
    {
        $this->id_meal->removeElement($idMeal);

        return $this;
    }
}
