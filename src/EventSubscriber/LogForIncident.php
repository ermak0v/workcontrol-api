<?php


namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Incident;
use App\Entity\Log;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Doctrine\ORM\EntityManagerInterface;

class LogForIncident implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['log', EventPriorities::POST_WRITE],
        ];
    }
    public function log(ViewEvent $event): void
    {
        $incident = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->getPathInfo();

        if ($incident instanceof Incident && Request::METHOD_POST === $method){
            $log = new Log();
            $log->setAction('create')
                ->setIncident($incident);

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }

        if ($incident instanceof Incident && Request::METHOD_PATCH === $method && $route === '/api/incidents/'.$incident->getId()){
            $log = new Log();
            $log->setAction('update')
                ->setIncident($incident);

            $incident->setUpdateAt($log->getCreatedAt());

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }

        if ($incident instanceof Incident && Request::METHOD_PATCH === $method && $route === '/api/incidents/'.$incident->getId().'delete'){
            $log = new Log();
            $log->setAction('delete')
                ->setIncident($incident);

            $incident->setFDelete(true);

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }
    }
}