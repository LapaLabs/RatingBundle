<?php

namespace LapaLabs\RatingBundle\Model;

use LapaLabs\RatingBundle\Form\DataTransformer\EntityToIdTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractRating
 */
abstract class AbstractRating implements EntityToIdTransformerInterface
{
    /**
     * @const float
     */
    const MAX_VALUE = 5.0;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $totalValues = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $totalVotes = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var AbstractVote[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="LapaLabs\RatingBundle\Model\AbstractVote", mappedBy="rating", cascade={"persist", "remove"})
     */
    protected $votes;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->votes = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float The rating value
     */
    public function getValue()
    {
        return 0 < $this->totalVotes
            ? $this->totalValues / $this->totalVotes
            : 0;
    }

    /**
     * @return float The relative rating value
     */
    public function getRelativeValue()
    {
        return 0 < $this->totalVotes
            ? ($this->totalValues / $this->totalVotes) / self::MAX_VALUE
            : 0;
    }

    /**
     * @return float The percentage rating value
     */
    public function getPercentageValue()
    {
        return 0 < $this->totalVotes
            ? ($this->totalValues / $this->totalVotes) / self::MAX_VALUE * 100
            : 0;
    }

    /**
     * @return $this
     */
    public function recalculate()
    {
        $this->totalValues = 0;
        $this->totalVotes = $this->votes->count();
        foreach ($this->votes as $vote) {
            $this->totalValues += $vote->getValue();
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalValues()
    {
        return $this->totalValues;
    }

    /**
     * @param float $totalValues
     * @return $this
     */
    public function setTotalValues($totalValues)
    {
        $this->totalValues = $totalValues;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalVotes()
    {
        return $this->totalVotes;
    }

    /**
     * @param float $totalVotes
     * @return $this
     */
    public function setTotalVotes($totalVotes)
    {
        $this->totalVotes = $totalVotes;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return AbstractVote[]|ArrayCollection
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param AbstractVote $vote
     * @return $this
     */
    public function addVote(AbstractVote $vote)
    {
        $vote->setRating($this);
        $this->votes->add($vote);

        return $this;
    }

    /**
     * @param AbstractVote[]|ArrayCollection $votes
     * @return $this
     */
    public function setVotes(ArrayCollection $votes)
    {
        foreach ($votes as $vote) {
            $vote->setRating($this);
        }
        $this->votes = $votes;

        return $this;
    }
}
