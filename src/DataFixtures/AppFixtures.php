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
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));

        $department = new Department();
        $department->setName('Отдел admin')
            ->setHead($user);

        $user->setDepartment($department);

        $manager->persist($user);
        $manager->persist($department);
        $manager->flush();

        for ($h = 1; $h < 4; $h++){
            $head = new User();
            $head->setEmail('head'.$h.'@head'.$h.'.com')
                ->setUsername('head'.$h)
                ->setRoles(['ROLE_HEAD'])
                ->setPassword($this->passwordEncoder->encodePassword($head, 'head'));

            $department = new Department();
            $department->setName('Отдел '.$h)
                ->setHead($head);

            $head->setDepartment($department);


            for ($u = 1; $u < 4; $u++){
                $user = new User();
                $user->setEmail($fake->email)
                    ->setUsername($fake->name)
                    ->setRoles(['ROLE_USER'])->setPassword($this->passwordEncoder->encodePassword($user, 'user'))
                    ->setDepartment($department);

                $manager->persist($user);
            }

            $manager->persist($department);
            $manager->persist($head);
        }

        $manager->flush();
    }
}
