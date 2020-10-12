<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Workers extends AbstractController
{
    public function __invoke()
    {
        return $this->getDoctrine()
            ->getRepository('Lokr:User')
            ->findUsersByRole('ROLE_USER');
    }
}