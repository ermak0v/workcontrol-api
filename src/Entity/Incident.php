<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IncidentRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Controller\SentIncidents;
use App\Controller\Incidents;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/incidents",
 *              "controller": Incidents::class
 *          },
 *          "post",
 *          "getSent"={
 *              "method"="GET",
 *              "path"="/incidents/sent",
 *              "controller": SentIncidents::class
 *          },
 *     },
 *     itemOperations={
 *          "get",
 *          "patch",
 *          "delete"={
 *              "method"="PATCH",
 *              "path"="/incidents/{id}/delete",
 *          },
 *          "moderate"={
 *              "method"="PATCH",
 *              "path"="/incidents/{id}/moderate",
 *          },
 *     }
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

    /**
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="incident")
     */
    private Collection $logs;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $f_delete;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $f_moder;

    public function __construct()
    {
        $this->f_delete = false;
        $this->f_moder = false;
        $this->createdAt = new DateTimeImmutable();
        $this->logs = new ArrayCollection();
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

    /**
     * @return Collection|Log[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setIncident($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getIncident() === $this) {
                $log->setIncident(null);
            }
        }

        return $this;
    }

    public function getFDelete(): ?bool
    {
        return $this->f_delete;
    }

    public function setFDelete(bool $f_delete): self
    {
        $this->f_delete = $f_delete;

        return $this;
    }

    public function getFModer(): ?bool
    {
        return $this->f_moder;
    }

    public function setFModer(bool $f_moder): self
    {
        $this->f_moder = $f_moder;

        return $this;
    }
}
