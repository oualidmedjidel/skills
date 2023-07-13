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

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'souscategorie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $category = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: self::class)]
    private Collection $souscategorie;

    #[ORM\OneToOne(mappedBy: 'category', cascade: ['persist', 'remove'])]
    private ?Sheet $sheet = null;

    public function __construct()
    {
        $this->souscategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(?self $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSouscategorie(): Collection
    {
        return $this->souscategorie;
    }

    public function addSouscategorie(self $souscategorie): static
    {
        if (!$this->souscategorie->contains($souscategorie)) {
            $this->souscategorie->add($souscategorie);
            $souscategorie->setCategory($this);
        }

        return $this;
    }

    public function removeSouscategorie(self $souscategorie): static
    {
        if ($this->souscategorie->removeElement($souscategorie)) {
            // set the owning side to null (unless already changed)
            if ($souscategorie->getCategory() === $this) {
                $souscategorie->setCategory(null);
            }
        }

        return $this;
    }

    public function getSheet(): ?Sheet
    {
        return $this->sheet;
    }

    public function setSheet(Sheet $sheet): static
    {
        // set the owning side of the relation if necessary
        if ($sheet->getCategory() !== $this) {
            $sheet->setCategory($this);
        }

        $this->sheet = $sheet;

        return $this;
    }
}
