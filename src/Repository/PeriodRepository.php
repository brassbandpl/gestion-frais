<?php

namespace App\Repository;

use App\Entity\Period;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Period|null find($id, $lockMode = null, $lockVersion = null)
 * @method Period|null findOneBy(array $criteria, array $orderBy = null)
 * @method Period[]    findAll()
 * @method Period[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Period::class);
    }

    public function findByDates($dateStart, $dateEnd) 
    {
        $queryBuilder = $this->createQueryBuilder('p');
        if ($dateEnd === null) {
            $queryBuilder->andWhere('p.dateEnd >= :dateStart');
        } else {
            $queryBuilder->andWhere('p.dateStart >= :dateStart and p.dateEnd <= :dateEnd');
            $queryBuilder->orWhere('p.dateStart <= :dateStart and p.dateEnd >= :dateStart');
            $queryBuilder->orWhere('p.dateStart <= :dateEnd and p.dateEnd >= :dateEnd');
            $queryBuilder->setParameter('dateEnd', $dateEnd);
        }
        $queryBuilder->setParameter('dateStart', $dateStart);
        $queryBuilder->orderBy('p.dateStart', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Period[] Returns an array of Period objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Period
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
