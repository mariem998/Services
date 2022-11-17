<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\ManyToOne(inversedBy: 'id_service')]
    private ?User $id_user = null;

    #[ORM\OneToMany(mappedBy: 'services', targetEntity: Checkout::class)]
    private Collection $formulaire_s;

    #[ORM\OneToMany(mappedBy: 'id_service', targetEntity: Category::class)]
    private Collection $category_id;

    public function __construct()
    {
        $this->formulaire_s = new ArrayCollection();
        $this->category_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection<int, Checkout>
     */
    public function getFormulaireS(): Collection
    {
        return $this->formulaire_s;
    }

    public function addFormulaire(Checkout $formulaire): self
    {
        if (!$this->formulaire_s->contains($formulaire)) {
            $this->formulaire_s->add($formulaire);
            $formulaire->setServices($this);
        }

        return $this;
    }

    public function removeFormulaire(Checkout $formulaire): self
    {
        if ($this->formulaire_s->removeElement($formulaire)) {
            // set the owning side to null (unless already changed)
            if ($formulaire->getServices() === $this) {
                $formulaire->setServices(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategoryId(): Collection
    {
        return $this->category_id;
    }

    public function addCategoryId(Category $categoryId): self
    {
        if (!$this->category_id->contains($categoryId)) {
            $this->category_id->add($categoryId);
            $categoryId->setIdService($this);
        }

        return $this;
    }

    public function removeCategoryId(Category $categoryId): self
    {
        if ($this->category_id->removeElement($categoryId)) {
            // set the owning side to null (unless already changed)
            if ($categoryId->getIdService() === $this) {
                $categoryId->setIdService(null);
            }
        }

        return $this;
    }
}
