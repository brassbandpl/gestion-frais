<?php

namespace App\Repository;

use App\Entity\ExpenseEvent;
use App\Entity\Period;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExpenseEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpenseEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpenseEvent[]    findAll()
 * @method ExpenseEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExpenseEvent::class);
    }

    public function findByUserAndPeriod(User $user, Period $period)
    {
        return $this->createQueryBuilder('e')
            ->join('e.event', 'ev')
            ->andWhere('ev.period = :period')
            ->setParameter('period', $period)
            ->andWhere('e.user = :user')
            ->setParameter('user', $user)
            ->orderBy('ev.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return ExpenseEvent[] Returns an array of ExpenseEvent objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpenseEvent
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
