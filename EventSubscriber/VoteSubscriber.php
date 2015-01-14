<?php

namespace LapaLabs\RatingBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;
use LapaLabs\RatingBundle\Model\AbstractVote;

/**
 * Class VoteSubscriber
 */
class VoteSubscriber implements EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof AbstractVote) {
            $this->assignVoter($entity);
        }
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof AbstractVote) {
            $this->assignVoter($entity);
        }
    }

    private function assignVoter(AbstractVote $vote)
    {
        /** @var SecurityContext $securityContext */
        $securityContext = $this->container->get('security.context');
        if ($token = $securityContext->getToken()) {
            $voter = $token->getUser();
            if ($voter instanceof UserInterface) {
                $vote->setVoter($voter);
            }
        }
    }
}
