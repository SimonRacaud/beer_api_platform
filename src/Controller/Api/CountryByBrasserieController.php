<?php

namespace App\Controller\Api;

use App\Repository\BrasserieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryByBrasserieController extends AbstractController
{
    private BrasserieRepository $repository;

    public function __construct(BrasserieRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->repository->getByCountry();
    }
}