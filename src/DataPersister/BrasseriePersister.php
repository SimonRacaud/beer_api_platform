<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Brasserie;

class BrasseriePersister implements ContextAwareDataPersisterInterface
{
    public EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Brasserie;
    }

    public function persist($data, array $context = [])
    {
        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $beers = $data->getBeers();
        foreach ($beers as $beer) {
            $this->em->remove($beer);
        }

        $this->em->remove($data);
        $this->em->flush();
    }
}