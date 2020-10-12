<?php

namespace App\Entity\Lokr;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use App\Controller\Workers;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get",
 *          "post",
 *          "getWorkers"={
 *              "method"="GET",
 *              "path"="/users/workers",
 *              "controller": Workers::class
 *          }
 *     },
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    use Timestamp;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=Incident::class, mappedBy="author")
     */
    private Collection $incidents;

    /**
     * @ORM\OneToMany(targetEntity=Incident::class, mappedBy="target")
     */
    private Collection $myIncidents;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="users")
     */
    private Department $department;

    /**
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="creator")
     */
    private Collection $logs;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->incidents = new ArrayCollection();
        $this->myIncidents = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    /**
     * @see UserInterface
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     * @return Collection|Incident[]
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): self
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents[] = $incident;
            $incident->setAuthor($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): self
    {
        if ($this->incidents->contains($incident)) {
            $this->incidents->removeElement($incident);
            // set the owning side to null (unless already changed)
            if ($incident->getAuthor() === $this) {
                $incident->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Incident[]
     */
    public function getMyIncidents(): Collection
    {
        return $this->myIncidents;
    }

    public function addMyIncident(Incident $myIncident): self
    {
        if (!$this->myIncidents->contains($myIncident)) {
            $this->myIncidents[] = $myIncident;
            $myIncident->setTarget($this);
        }

        return $this;
    }

    public function removeMyIncident(Incident $myIncident): self
    {
        if ($this->myIncidents->contains($myIncident)) {
            $this->myIncidents->removeElement($myIncident);
            // set the owning side to null (unless already changed)
            if ($myIncident->getTarget() === $this) {
                $myIncident->setTarget(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

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
            $log->setCreator($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getCreator() === $this) {
                $log->setCreator(null);
            }
        }

        return $this;
    }
}
