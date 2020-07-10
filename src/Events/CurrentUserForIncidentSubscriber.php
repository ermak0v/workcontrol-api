<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Incident;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CurrentUserForIncidentSubscriber implements EventSubscriberInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['currentUserForIncident', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function currentUserForIncident(ViewEvent $event): void
    {
        $incident = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($incident instanceof Incident && Request::METHOD_POST === $method){
            $incident->setAuthor($this->security->getUser());
        }
    }
}