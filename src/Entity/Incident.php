<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IncidentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *
 * )
 * @ORM\Entity(repositoryClass=IncidentRepository::class)
 */
class Incident
{
    use Timestamp;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="incidents")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserInterface $author;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="myIncidents")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $target;

    /**
     * @ORM\Column(type="text")
     */
    private string $proof;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $f_positive;

    /**
     * @ORM\ManyToOne(targetEntity=Criterion::class, inversedBy="incidents")
     * @ORM\JoinColumn(nullable=false)
     */
    private Criterion $criterion;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): UserInterface
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTarget(): ?User
    {
        return $this->target;
    }

    public function setTarget(?User $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getProof(): ?string
    {
        return $this->proof;
    }

    public function setProof(string $proof): self
    {
        $this->proof = $proof;

        return $this;
    }

    public function getFPositive(): ?bool
    {
        return $this->f_positive;
    }

    public function setFPositive(bool $f_positive): self
    {
        $this->f_positive = $f_positive;

        return $this;
    }

    public function getCriterion(): ?Criterion
    {
        return $this->criterion;
    }

    public function setCriterion(?Criterion $criterion): self
    {
        $this->criterion = $criterion;

        return $this;
    }
}
