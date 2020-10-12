<?php


namespace App\Controller;

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
                ->getRepository('Lokr:Incident')
                ->findBy([],
                    ['createdAt' => 'DESC']
                );
        } else if ($role === 'ROLE_HEAD') {
            $target = $this->getDoctrine()
                ->getRepository('Lokr:User')
                ->findBy(
                    ['department' => $department],
                    ['createdAt' => 'DESC']
                );
            return $this->getDoctrine()
                ->getRepository('Lokr:Incident')
                ->findBy(
                    ['target' => $target],
                    ['createdAt' => 'DESC'],
                );
        } else {
            return null;
        }
    }
}