<?php

namespace LapaLabs\RatingBundle\Form\DataTransformer;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntityToIdTransformer
 */
class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var EntityRepository
     */
    private $er;

    /**
     * @param EntityRepository $er
     */
    public function __construct(EntityRepository $er)
    {
        $this->er = $er;
    }

    /**
     * Transforms an object (entity) to an integer (id).
     *
     * @param  EntityToIdTransformerInterface $entity
     * @return integer
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return null;
        }

        if (! $entity instanceof EntityToIdTransformerInterface) {
            throw new TransformationFailedException(sprintf(
                'The entity must implements %s',
                EntityToIdTransformerInterface::class
            ));
        }

        return $entity->getId();
    }

    /**
     * Transforms an integer (id) to an object (entity).
     *
     * @param integer $id
     * @return EntityToIdTransformerInterface
     * @throws TransformationFailedException if object (entity) is not found.
     */
    public function reverseTransform($id)
    {
        $id = (int)$id;

        if (0 >= $id) {
            return null;
        }

        $entity = $this->er->find($id);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'The "%s" entity with ID "%s" does not exist!',
                $this->er->getClassName(),
                $id
            ));
        }

        if (! $entity instanceof EntityToIdTransformerInterface) {
            throw new TransformationFailedException(sprintf(
                'The entity must implements %s',
                EntityToIdTransformerInterface::class
            ));
        }

        return $entity;
    }
}
