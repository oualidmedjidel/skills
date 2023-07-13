<?php

namespace App\Entity;

use App\Repository\SheetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SheetRepository::class)]
class Sheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $visio = null;

    #[ORM\Column]
    private ?bool $faceToface = null;

    #[ORM\OneToOne(inversedBy: 'sheet', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'sheet', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?category $category = null;

    #[ORM\ManyToMany(targetEntity: language::class, inversedBy: 'sheets')]
    private Collection $language;

    #[ORM\OneToOne(mappedBy: 'sheet', cascade: ['persist', 'remove'])]
    private ?Lesson $lesson = null;

    public function __construct()
    {
        $this->language = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isVisio(): ?bool
    {
        return $this->visio;
    }

    public function setVisio(bool $visio): static
    {
        $this->visio = $visio;

        return $this;
    }

    public function isFaceToface(): ?bool
    {
        return $this->faceToface;
    }

    public function setFaceToface(bool $faceToface): static
    {
        $this->faceToface = $faceToface;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, language>
     */
    public function getLanguage(): Collection
    {
        return $this->language;
    }

    public function addLanguage(language $language): static
    {
        if (!$this->language->contains($language)) {
            $this->language->add($language);
        }

        return $this;
    }

    public function removeLanguage(language $language): static
    {
        $this->language->removeElement($language);

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(Lesson $lesson): static
    {
        // set the owning side of the relation if necessary
        if ($lesson->getSheet() !== $this) {
            $lesson->setSheet($this);
        }

        $this->lesson = $lesson;

        return $this;
    }
}
