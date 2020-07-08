<?php

namespace App\Denormalizer;

use App\Denormalizer\AbstractEntityDenormalizer;
use App\Entity\User;

class UserDenormalizer extends AbstractEntityDenormalizer
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === User::class;
    }

    protected function insertSubEntity(array $data, $entity): void
    {
        
    }
}