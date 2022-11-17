<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Service::class)]
    private Collection $id_service;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: Checkout::class)]
    private Collection $formulaire;

    public function __construct()
    {
        $this->id_service = new ArrayCollection();
        $this->formulaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getIdService(): Collection
    {
        return $this->id_service;
    }

    public function addIdService(Service $idService): self
    {
        if (!$this->id_service->contains($idService)) {
            $this->id_service->add($idService);
            $idService->setIdUser($this);
        }

        return $this;
    }

    public function removeIdService(Service $idService): self
    {
        if ($this->id_service->removeElement($idService)) {
            // set the owning side to null (unless already changed)
            if ($idService->getIdUser() === $this) {
                $idService->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Checkout>
     */
    public function getFormulaire(): Collection
    {
        return $this->formulaire;
    }

    public function addFormulaire(Checkout $formulaire): self
    {
        if (!$this->formulaire->contains($formulaire)) {
            $this->formulaire->add($formulaire);
            $formulaire->setIdClient($this);
        }

        return $this;
    }

    public function removeFormulaire(Checkout $formulaire): self
    {
        if ($this->formulaire->removeElement($formulaire)) {
            // set the owning side to null (unless already changed)
            if ($formulaire->getIdClient() === $this) {
                $formulaire->setIdClient(null);
            }
        }

        return $this;
    }
}
