<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Workers extends AbstractController
{
    public function __invoke()
    {
        return $this->getDoctrine()
            ->getRepository('App:User')
            ->findUsersByRole('ROLE_USER');
    }
}