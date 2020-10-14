<?php

namespace App\Repository\Lokr;

use App\Entity\Lokr\Department;
use App\Entity\Lokr\User;
use App\Entity\Project\ViewUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    private EntityManagerInterface $entityManager;
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;

        parent::__construct($this->managerRegistry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findUsersByRole($role)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%');

        return $qb->getQuery()->getResult();
    }

    public function loadUserByUsername($login)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['login' => $login]);

        if (is_null($user)) {
            $viewUser = $this->managerRegistry->getRepository(ViewUsers::class)->findOneBy(['login' => $login]);

            if (!is_null($viewUser)) {
                $department = $this->managerRegistry->getRepository(Department::class)->findOneBy(['name' => $viewUser->getGroup()]);

                if (is_null($department)) {
                    $head = $this->entityManager->getRepository(User::class)->findUsersByRole('ROLE_ADMIN');

                    $department = new Department();
                    $department->setName($viewUser->getGroup())
                        ->setHead($head);

                    $this->entityManager->persist($department);
                }

                $newUser = new User();
                $newUser->setEmail($viewUser->getEmail())
                    ->setUsername($viewUser->getFullname())
                    ->setLogin($viewUser->getLogin())
                    ->setRoles(['ROLE_USER'])
                    ->setPassword($viewUser->getPassword())
                    ->setDepartment($department);

                $this->entityManager->persist($newUser);
                $this->entityManager->flush();

                $user = $newUser;
            }
        }

        return $user;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
