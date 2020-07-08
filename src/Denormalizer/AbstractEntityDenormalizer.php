<?php

namespace App\Denormalizer;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractEntityDenormalizer implements DenormalizerInterface
{
    private ObjectNormalizer $normalizer;
    protected EntityManagerInterface $em;

    public function __construct(ObjectNormalizer $normalizer, EntityManagerInterface $em)
    {
        $this->normalizer = $normalizer;
        $this->em = $em;
    }

    public function denormalize($data, $type, $format = null, array $context = [])
    {
        $entity = $this->normalizer->denormalize($data, $type, $format, $context);

        if (
            (array_key_exists("collection_operation_name", $context) && $context["collection_operation_name"] == "post")
            || (array_key_exists("item_operation_name", $context) && $context["item_operation_name"] == "post")
        ) {
            $entity->setDateCreate(new \DateTime());
        }
        $entity->setDateUpdate(new \DateTime());

        $this->insertSubEntity($data, $entity);
        
        return $entity;
    }

    abstract protected function insertSubEntity(array $data, $entity): void;

    protected function insertThatSubEntity(array $data, $entity, string $subEntityName): void
    {
        if (array_key_exists($subEntityName . '_id', $data)) {
            $repository = $this->em->getRepository('App\\Entity\\' . ucfirst($subEntityName));
            $subEntity = $repository->find($data[$subEntityName . '_id']);
            if (null == $subEntity) {
                throw new EntityNotFoundException(ucfirst($subEntityName) . " id not found");
            }
            $methodName = 'set' . ucfirst($subEntityName); 
            $entity->$methodName($subEntity);
        }
    }

}