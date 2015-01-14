<?php

namespace LapaLabs\RatingBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AbstractVote
 */
abstract class AbstractVote
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $value = AbstractRating::MAX_VALUE;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={ "unsigned": true })
     */
    protected $ip = 0;

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
     * @var AbstractRating
     *
     * @ORM\ManyToOne(targetEntity="LapaLabs\RatingBundle\Model\AbstractRating", inversedBy="votes")
     */
    protected $rating;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     */
    protected $voter;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);

        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return long2ip($this->ip);
    }

    /**
     * @param int $ip
     * @return $this
     */
    public function setIntIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return int
     */
    public function getIntIp()
    {
        return $this->ip;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param AbstractRating $rating
     * @return $this
     */
    public function setRating(AbstractRating $rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return AbstractRating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param UserInterface $voter
     * @return $this
     */
    public function setVoter($voter)
    {
        $this->voter = $voter;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getVoter()
    {
        return $this->voter;
    }
}
