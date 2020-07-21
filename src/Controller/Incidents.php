<?php


namespace App\Controller;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class Incidents extends AbstractController
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
        $role = $this->security->getUser()->getRoles()[0];
        $department = $this->security->getUser()->getDepartment();

        if ($role === 'ROLE_ADMIN') {
            return $this->getDoctrine()
                ->getRepository('App:Incident')
                ->findAll();
        } else if ($role === 'ROLE_HEAD') {
            $authors = $this->getDoctrine()
                ->getRepository('App:User')
                ->findBy(
                    ['department' => $department]
                );
            return $this->getDoctrine()
                ->getRepository('App:Incident')
                ->findBy(
                    ['author' => $authors]
                );
        } else {
            return null;
        }
    }
}