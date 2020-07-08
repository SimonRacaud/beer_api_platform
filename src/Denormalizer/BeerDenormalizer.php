<?php

namespace App\Denormalizer;

use App\Entity\Beer;
use App\Denormalizer\AbstractEntityDenormalizer;

class BeerDenormalizer extends AbstractEntityDenormalizer
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Beer::class;
    }

    protected function insertSubEntity(array $data, $entity): void
    {
        $this->insertThatSubEntity($data, $entity, 'brasserie');
    }
}