<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class LogsUpdateModerate extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke()
    {
        $role = $this->security->getUser()->getRoles()[0];

        if ($role === 'ROLE_ADMIN' || $role === 'ROLE_HEAD') {
            return $this->getDoctrine()
                ->getRepository('App:Log')
                ->findBy(
                    ['action' => ['update', 'moderate', 'delete', 'create']],
                    ['createdAt' => 'DESC']
                );
        } else {
            return null;
        }
    }
}