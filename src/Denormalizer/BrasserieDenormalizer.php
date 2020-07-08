<?php

namespace App\Denormalizer;

use App\Entity\Brasserie;
use App\Denormalizer\AbstractEntityDenormalizer;

class BrasserieDenormalizer extends AbstractEntityDenormalizer
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Brasserie::class;
    }

    protected function insertSubEntity(array $data, $entity): void
    {
        
    }
}