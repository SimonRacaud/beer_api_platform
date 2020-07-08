<?php

namespace App\Controller\Api;

use App\Repository\BeerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BeerByIbuController extends AbstractController
{
    private BeerRepository $repository;

    public function __construct(BeerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->repository->getByIBU(10);
    }
}