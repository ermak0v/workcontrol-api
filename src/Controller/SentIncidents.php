<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SentIncidents extends AbstractController
{
    private Security $security;
    private EntityManagerInterface $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    public function __invoke()
    {
        $user = $this->security->getUser();

        return $this->getDoctrine()
            ->getRepository('App:Incident')->findBy(
                ['author' => $user],
                ['createdAt' => 'DESC']
            );
    }
}