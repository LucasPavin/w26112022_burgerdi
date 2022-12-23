<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Contraints as Assert;

// use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
// use Symfony\Component\Validator\Contraints as Assert;

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

    #[ORM\Column(type:"text", nullable:true)]
    private ?int $calorie = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agency $id_agency = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy:'id_meal')]
    #[JoinTable(name: 'meal_category')]
    private Collection $id_category;

    #[ORM\Column(type: "datetime")]
    // #[Assert\NotNull()]
    private \DateTime $createAt;

    #[ORM\OneToMany(mappedBy: 'meal', targetEntity: Notice::class, orphanRemoval: true)]
    private Collection $notices;

    private ?float $average = null;
    private ?string $comment = null;

    public function __construct()
    {
        $this->id_category = new ArrayCollection();
        $this->createAt = new \DateTime;
        $this->notices = new ArrayCollection();
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

    public function getIdAgency(): ?Agency
    {
        return $this->id_agency;
    }

    public function setIdAgency(?Agency $id_agency): self
    {
        $this->id_agency = $id_agency;

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getIdCategory(): Collection
    {
        return $this->id_category;
    }

    public function addIdCategory(Category $idCategory): self
    {
        if (!$this->id_category->contains($idCategory)) {
            $this->id_category[] = $idCategory;
            $idCategory->addIdMeal($this);
        }

        return $this;
    }

    public function removeIdCategory(Category $idCategory): self
    {
        if (!$this->id_category->contains($idCategory)) {
            $this->id_category->removeElement($idCategory);
            $idCategory->removeIdMeal($this);
        }
        // $this->id_category->removeElement($idCategory);
    
        return $this;
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTime $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection<int, Notice>
     */
    public function getNotices(): Collection
    {
        return $this->notices;
    }

    public function addNotice(Notice $notice): self
    {
        if (!$this->notices->contains($notice)) {
            $this->notices->add($notice);
            $notice->setMeal($this);
        }

        return $this;
    }

    public function removeNotice(Notice $notice): self
    {
        if ($this->notices->removeElement($notice)) {
            // set the owning side to null (unless already changed)
            if ($notice->getMeal() === $this) {
                $notice->setMeal(null);
            }
        }

        return $this;
    }
    public function getAverage()
    {
        $notices = $this->notices;
        if ($notices->toArray() === []) {
            $this->average = null;
            return $this->average;
        }
        $total = 0;
        foreach ($notices as $notice) {
            $total += $notice->getRating();
        }
        $this->average = $total / count($notices);
        return $this->average;
    }

    public function getComment()
    {
        $notices = $this->notices;

        if ($notices->toArray() === []) {
            $this->comment = null;
            return $this->comment;
        }
        $total = [];
        foreach ($notices as $notice) {
            $total = $notice->getComment();
        }
        $this->comment = $total;
        return $this->comment;
    }
}
