<?php


namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Lokr\Incident;
use App\Entity\Lokr\Log;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class LogForIncident implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
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
                ->setIncident($incident)
                ->setTarget($incident->getTarget())
                ->setCriterion($incident->getCriterion())
                ->setDescription($incident->getDescription())
                ->setProof($incident->getProof())
                ->setFPositive($incident->getFPositive())
                ->setFEpic($incident->getFEpic())
                ->setCreator($this->security->getUser());

            $this->entityManager->persist($log);

            if ($incident->getFModer()){
                $log = new Log();
                $log->setAction('moderate')
                    ->setIncident($incident)
                    ->setTarget($incident->getTarget())
                    ->setCriterion($incident->getCriterion())
                    ->setDescription($incident->getDescription())
                    ->setProof($incident->getProof())
                    ->setFPositive($incident->getFPositive())
                    ->setFEpic($incident->getFEpic())
                    ->setCreator($this->security->getUser());
            }

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }

        if ($incident instanceof Incident && Request::METHOD_PATCH === $method && $route === '/api/incidents/'.$incident->getId()){
            $log = new Log();
            $log->setAction('update')
                ->setIncident($incident)
                ->setTarget($incident->getTarget())
                ->setCriterion($incident->getCriterion())
                ->setDescription($incident->getDescription())
                ->setProof($incident->getProof())
                ->setFPositive($incident->getFPositive())
                ->setFEpic($incident->getFEpic())
                ->setCreator($this->security->getUser());

            $incident->setUpdateAt($log->getCreatedAt());

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }

        if ($incident instanceof Incident && Request::METHOD_PATCH === $method && $route === '/api/incidents/'.$incident->getId().'delete'){
            $log = new Log();
            $log->setAction('delete')
                ->setIncident($incident)
                ->setTarget($incident->getTarget())
                ->setCriterion($incident->getCriterion())
                ->setDescription($incident->getDescription())
                ->setProof($incident->getProof())
                ->setFPositive($incident->getFPositive())
                ->setFEpic($incident->getFEpic())
                ->setCreator($this->security->getUser());

            $incident->setFDelete(true);

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }

        if ($incident instanceof Incident && Request::METHOD_PATCH === $method && $route === '/api/incidents/'.$incident->getId().'moderate'){
            $log = new Log();
            $log->setAction('moderate')
                ->setIncident($incident)
                ->setTarget($incident->getTarget())
                ->setCriterion($incident->getCriterion())
                ->setDescription($incident->getDescription())
                ->setProof($incident->getProof())
                ->setFPositive($incident->getFPositive())
                ->setFEpic($incident->getFEpic())
                ->setCreator($this->security->getUser());

            $incident->setFModer(true);

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }

        if ($incident instanceof Incident && Request::METHOD_PATCH === $method && $route === '/api/incidents/'.$incident->getId().'no-moderate'){
            $log = new Log();
            $log->setAction('noModerate')
                ->setIncident($incident)
                ->setTarget($incident->getTarget())
                ->setCriterion($incident->getCriterion())
                ->setDescription($incident->getDescription())
                ->setProof($incident->getProof())
                ->setFPositive($incident->getFPositive())
                ->setFEpic($incident->getFEpic())
                ->setCreator($this->security->getUser());

            $incident->setFModer(false);

            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }
    }
}