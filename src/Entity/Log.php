<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use App\Controller\LogsUpdateModerate;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get",
 *          "getUpdateModerate"={
 *              "method"="GET",
 *              "path"="/logs/update-moderate",
 *              "controller": LogsUpdateModerate::class
 *          }
 *      },
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=LogRepository::class)
 */
class Log
{
    use Timestamp;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $action;

    /**
     * @ORM\ManyToOne(targetEntity=Incident::class, inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     */
    private Incident $incident;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $creator;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $target;

    /**
     * @ORM\ManyToOne(targetEntity=Criterion::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Criterion $criterion;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="text")
     */
    private string $proof;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $f_positive;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getIncident(): ?Incident
    {
        return $this->incident;
    }

    public function setIncident(?Incident $incident): self
    {
        $this->incident = $incident;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

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

    public function getCriterion(): ?Criterion
    {
        return $this->criterion;
    }

    public function setCriterion(?Criterion $criterion): self
    {
        $this->criterion = $criterion;

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
}
