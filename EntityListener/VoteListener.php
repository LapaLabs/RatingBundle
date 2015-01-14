<?php

namespace LapaLabs\RatingBundle\EntityListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use LapaLabs\RatingBundle\Model\AbstractVote;

/**
 * Class VoteListener
 */
class VoteListener
{
    public function prePersist(AbstractVote $vote, LifecycleEventArgs $event)
    {
        $now = new \DateTime();
        $vote->setCreatedAt($now);
    }

    public function preUpdate(AbstractVote $vote, PreUpdateEventArgs $event)
    {
        $now = new \DateTime();
        $vote->setUpdatedAt($now);
    }

    public function postPersist(AbstractVote $vote, LifecycleEventArgs $event)
    {
        $this->recalculateRating($vote);
        $event->getEntityManager()->flush();
    }

    public function postUpdate(AbstractVote $vote, LifecycleEventArgs $event)
    {
        $this->recalculateRating($vote);
        $event->getEntityManager()->flush();
    }

    private function recalculateRating(AbstractVote $vote)
    {
        if ($rating = $vote->getRating()) {
            $rating->recalculate();
        }
    }
}
