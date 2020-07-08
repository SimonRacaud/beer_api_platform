<?php

namespace App\Denormalizer;

use App\Denormalizer\AbstractEntityDenormalizer;
use App\Entity\Checkin;

class CheckinDenormalizer extends AbstractEntityDenormalizer
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Checkin::class;
    }

    protected function insertSubEntity(array $data, $entity): void
    {
        $this->insertThatSubEntity($data, $entity, 'user');
        $this->insertThatSubEntity($data, $entity, 'beer');
    }
}