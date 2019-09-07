<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findByNotClosedAndDateLessThan(\DateTime $date): iterable
    {
        $query = $this->createQueryBuilder('event');
        $query->andWhere('event.closed = false');
        $query->andWhere('event.date <= :date');
        $query->setParameter('date', $date);

        return $query->getQuery()->getResult();
    }

    public function findByNotClosedAndBetweenDates(\DateTime $dateBegin, ?\DateTime $dateEnd): iterable
    {
        $query = $this->createQueryBuilder('event');
        $query->andWhere('event.closed = false');
        $query->andWhere('event.date >= :dateBegin');
        $query->setParameter('dateBegin', $dateBegin);
        if($dateEnd){
            $query->andWhere('event.date <= :dateEnd');
            $query->setParameter('dateEnd', $dateEnd);
        }
        $query->orderBy('event.date', 'ASC');

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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
