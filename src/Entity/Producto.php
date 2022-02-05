<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 * 
 * @UniqueEntity("code","name")
 * 
 * @ORM\HasLifecycleCallbacks()
 */
class Producto
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
     * 
     * @Assert\Length(
     *   min = 4,
     *   max = 10,
     *   minMessage = "tu nombre Tiene muy pocos Caracteres",
     *   maxMessage = "tu nombre tiene demasiados Caracteres"
     * )
     * @Assert\Type(
     *   type= "alnum",
     *   message="Este codigó contiene caracteres especiales"
     * )
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     * 
     * @Assert\Length(
     *   min= 4
     * )
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     */
    private $brand;
    

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="productos")
     * 
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     * 
     */
    private $Categorya;

    /**
     * @ORM\Column(type="float")
     * 
     * @Assert\NotBlank(message="Este campo no puede estar blanco")
     * 
     * @Assert\Positive
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * 
     * 
     */
    private $createdaAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     * 
     */
    private $updateAt;

     /**
     * @ORM\PrePersist()
     */
    public function setCreatedAtvalue()
    {
       $this->createdaAt = new \DateTime();
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
        return $this->name."-".$this->code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategorya(): ?Category
    {
        return $this->Categorya;
    }

    public function setCategorya(?Category $Categorya): self
    {
        $this->Categorya = $Categorya;

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

    public function getCreatedaAt(): ?\DateTimeInterface
    {
        return $this->createdaAt;
    }

    public function setCreatedaAt(\DateTimeInterface $createdaAt): self
    {
        $this->createdaAt = $createdaAt;

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
}
