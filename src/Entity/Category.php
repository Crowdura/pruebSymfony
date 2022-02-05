<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * 
 * @UniqueEntity("name")
 * 
 *@ORM\HasLifecycleCallbacks()
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $active;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $updateAt;

    /**
     * @ORM\OneToMany(targetEntity=Producto::class, mappedBy="Categorya")
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     */
    private $productos;

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAtvalue()
    {
       $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     * 
     * @ORM\PreUpdate()
     */
    public function setUpdatedAtAtvalue()
    {
       $this->updateAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->name."-".$this->id;
    }

    public function __construct()
    {
        $this->productos = new ArrayCollection();
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection|Producto[]
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
            $producto->setCategorya($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        if ($this->productos->removeElement($producto)) {
            // set the owning side to null (unless already changed)
            if ($producto->getCategorya() === $this) {
                $producto->setCategorya(null);
            }
        }

        return $this;
    }
}
