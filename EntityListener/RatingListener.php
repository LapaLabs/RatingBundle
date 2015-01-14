<?php

namespace LapaLabs\RatingBundle\EntityListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use LapaLabs\RatingBundle\Model\AbstractRating;

/**
 * Class RatingListener
 */
class RatingListener
{
    public function prePersist(AbstractRating $rating, LifecycleEventArgs $event)
    {
        $now = new \DateTime();
        $rating->setCreatedAt($now);
    }

    public function preUpdate(AbstractRating $rating, PreUpdateEventArgs $event)
    {
        $now = new \DateTime();
        $rating->setUpdatedAt($now);
    }
}
