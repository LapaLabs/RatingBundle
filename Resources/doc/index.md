# Getting Started

## Install

Install bundle with `Composer` dependency manager first by running the command:

`$ composer require "lapalabs/rating-bundle:dev-master"`

## Include

Enable the bundle in application kernel for `prod` environment:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // other bundles...
        new LapaLabs\RatingBundle\LapaLabsRatingBundle(),
    );
}
```

## Create your Rating class

``` php
<?php

namespace Acme\RatingBundle\Entity;

use LapaLabs\RatingBundle\Model\AbstractRating as BaseRating;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="rating")
 * @ORM\EntityListeners(value={ "LapaLabs\RatingBundle\EntityListener\RatingListener" })
 */
class Rating extends BaseRating
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}

```

## Create your Vote class

``` php
<?php

namespace Acme\RatingBundle\Entity;

use LapaLabs\RatingBundle\Model\AbstractVote as BaseVote;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="vote")
 * @ORM\EntityListeners(value={ "LapaLabs\RatingBundle\EntityListener\VoteListener" })
 */
class Vote extends BaseVote
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}

```

## Resolve abstract entities with your

``` yaml
doctrine:
    orm:
        resolve_target_entities:
            Symfony\Component\Security\Core\User\UserInterface: Acme\UserBundle\Entity\User # voter entity
            LapaLabs\RatingBundle\Model\AbstractVote: Acme\RatingBundle\Entity\Vote
            LapaLabs\RatingBundle\Model\AbstractRating: Acme\RatingBundle\Entity\Rating
```

* Meaning that you already have your `User` entity. Create it if not.
You can easy use amazing [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) for it.

## Update database schema

``` bash
$ php app/console doctrine:schema:update --force
```

## Define your own form with data transformer

The docs will be later... Try to create it by yourself using [Symfony Forms docs](http://symfony.com/doc/current/book/forms.html)

## Congratulations!

You're ready to use it!
