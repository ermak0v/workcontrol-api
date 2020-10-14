<?php

namespace App\DataFixtures;

use App\Entity\Lokr\Department;
use App\Entity\Lokr\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create();

        $user = new User();
        $user->setEmail('admin@admin.com')
            ->setLogin('a.admin')
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));

        $department = new Department();
        $department->setName('admin')
            ->setHead($user);

        $user->setDepartment($department);

        $manager->persist($user);
        $manager->persist($department);

        $user = new User();
        $user->setEmail('www@www.com')
            ->setLogin('w.www')
            ->setUsername('wwww')
            ->setRoles(['ROLE_HEAD'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'www'));

        $department = new Department();
        $department->setName('www')
            ->setHead($user);

        $user->setDepartment($department);

        $manager->persist($user);
        $manager->persist($department);

        $user = new User();
        $user->setEmail('support@support.com')
            ->setLogin('s.support')
            ->setUsername('support')
            ->setRoles(['ROLE_HEAD'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'support'));

        $department = new Department();
        $department->setName('support')
            ->setHead($user);

        $user->setDepartment($department);

        $manager->persist($user);
        $manager->persist($department);

        $user = new User();
        $user->setEmail('sales@sales.com')
            ->setLogin('s.sales')
            ->setUsername('sales')
            ->setRoles(['ROLE_HEAD'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'sales'));

        $department = new Department();
        $department->setName('sales')
            ->setHead($user);

        $user->setDepartment($department);

        $manager->persist($user);
        $manager->persist($department);

        $manager->flush();
    }
}
