<?php

namespace App\Controller\Api;

use App\Repository\CheckinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BeerByMarkController extends AbstractController
{
    private CheckinRepository $repository;

    public function __construct(CheckinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->repository->getByMark();
    }
}