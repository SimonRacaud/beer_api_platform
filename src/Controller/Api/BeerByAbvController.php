<?php

namespace App\Controller\Api;

use App\Repository\BeerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BeerByAbvController extends AbstractController
{
    private BeerRepository $repository;

    public function __construct(BeerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->repository->getByABV(10);
    }
}