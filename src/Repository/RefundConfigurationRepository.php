<?php

namespace App\Repository;

use App\Entity\RefundConfiguration;
use App\Exception\RefundConfigurationNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefundConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefundConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefundConfiguration[]    findAll()
 * @method RefundConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefundConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefundConfiguration::class);
    }

    public function findOneForDate(\DateTimeInterface $date): RefundConfiguration
    {
        $refundConfigs = $this->createQueryBuilder('r')
            ->andWhere('r.dateStart <= :startDate')
            ->setParameter('startDate', $date)
            ->orderBy('r.dateStart', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;

        if (count($refundConfigs) === 0) {
            throw new RefundConfigurationNotFoundException(sprintf('Refund configuration not found for %s', $date->format('Y-m-d')));
        }

        return $refundConfigs[0];
    }
}
