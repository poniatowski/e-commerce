<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    // TODO - change it to uuid
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Sequentially({
     *     @Assert\NotBlank(),
     *     @Assert\Length(
     *          min = 3,
     *          max = 3
     *      )
     * }, groups={"create", "edit"})
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Sequentially({
     *     @Assert\NotBlank(),
     *     @Assert\Length(
     *          min = 3,
     *          max = 255
     *      )
     * }, groups={"create", "edit"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", length=255)
     * @Assert\Sequentially({
     *     @Assert\NotBlank(),
     *     @Assert\Length(
     *          min = 100,
     *          max = 255
     *      )
     * }, groups={"create", "edit"})
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     * @Assert\Sequentially({
     *     @Assert\NotBlank(),
     *     @Assert\Length(
     *          min = 0,
     *     ),
     *     @Assert\Type(
     *          type="float",
     *          message="The value {{ value }} is not a valid {{ type }}."
     *     )
     * }, groups={"create", "edit"})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $removed;


    public function setId(int $id): ?self
    {
        $this->id = $id;

        return $this;
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
        return (float)number_format((float)$this->price, 2);
    }

    public function setPrice(float $price): self
    {
        $this->price = (float)number_format($price, 2);

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getRemoved(): ?\DateTimeInterface
    {
        return $this->removed;
    }

    public function setRemoved(?\DateTimeInterface $removed): self
    {
        $this->removed = $removed;

        return $this;
    }
}
