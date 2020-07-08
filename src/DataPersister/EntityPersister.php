<?php

namespace App\DataPersister;

use App\Entity\Beer;
use App\Entity\User;
use App\Entity\Checkin;
use App\Entity\Brasserie;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class EntityPersister implements ContextAwareDataPersisterInterface
{
    public EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Brasserie
            || $data instanceof Beer
            || $data instanceof Checkin
            || $data instanceof User
            ;
    }

    public function persist($data, array $context = [])
    {
        $this->em->persist($data);
        $this->em->flush();
        /**
         * Ununsed DataPersister
         */
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}