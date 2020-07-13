<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $user = new User();
        $user->setEmail('admin@admin.com')
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN']);

        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $manager->persist($user);

        $fake = Factory::create();

        for ($u = 0; $u < 5; $u++){
            $user = new User();
            $user->setEmail($fake->email)
                ->setUsername($fake->name)
                ->setRoles(['ROLE_USER']);

            $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
