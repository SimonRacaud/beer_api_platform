<?php

namespace App\Repository;

use App\Entity\Checkin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Checkin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checkin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checkin[]    findAll()
 * @method Checkin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checkin::class);
    }

    public function getByMark()
    {
        $rawSql = "
            SELECT AVG(checkin.mark) as mark, beer.name as beer, beer.abv, beer.ibu, beer.date_create, beer.date_update, brasserie.name as brasserie
            FROM checkin
            LEFT JOIN beer ON checkin.beer_id = beer.id
            LEFT JOIN brasserie ON beer.brasserie_id = brasserie.id
            GROUP BY beer.id
        ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

    // /**
    //  * @return Checkin[] Returns an array of Checkin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Checkin
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
