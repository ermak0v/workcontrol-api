<?php


namespace App\Entity\Project;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * Class ViewUsers
 * @package App\Entity\Project
 *
 * @ORM\Entity(
 *     readOnly=true,
 *     repositoryClass="App\Repository\Project\ViewUsersRepository"
 * )
 *
 * @ORM\Table(name="viewUsers")
 */
class ViewUsers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(
     *     name="sdesk_user",
     *     type="integer",
     *     unique=true
     * )
     */
    private int $id;

    /**
     * @ORM\Column(
     *     name="login",
     *     type="string",
     *     unique=true
     * )
     */
    private string $login;

    /**
     * @ORM\Column(
     *     name="password",
     *     type="string",
     * )
     */
    private string $password;

    /**
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     unique=true
     * )
     */
    private string $email;

    /**
     * @ORM\Column(
     *     name="group_id",
     *     type="string",
     * )
     */
    private string $group;

    /**
     * @ORM\Column(
     *     name="fullname",
     *     type="string"
     * )
     */
    private string $fullname;

    /**
     * @ORM\Column(
     *     name="is_duty_web",
     *     type="integer"
     * )
     */
    private int $isDutyWeb;

    /**
     * @ORM\Column(
     *     name="is_duty_valuer",
     *     type="integer"
     * )
     */
    private int $isDutyValuer;

    /**
     * @ORM\Column(
     *     name="is_duty_admin",
     *     type="integer"
     * )
     */
    private int $isDutyAdmin;

    /**
     * @ORM\Column(
     *     name="workgroup",
     *     type="string"
     * )
     */
    private string $workgroup;

    /**
     * @ORM\Column(
     *     name="wrk_leader",
     *     type="string"
     * )
     */
    private string $wrkLeader;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getFullname(): string
    {
        return trim($this->fullname);
    }

    public function getIsDutyWeb(): int
    {
        return $this->isDutyWeb;
    }

    public function getIsDutyValuer(): int
    {
        return $this->isDutyValuer;
    }

    public function getIsDutyAdmin(): int
    {
        return $this->isDutyAdmin;
    }

    public function getWorkgroup(): ?string
    {
        return $this->workgroup;
    }

    public function getWrkLeader(): ?string
    {
        return $this->wrkLeader;
    }

}