<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function findByCountryCodeAndName(string $countryCode,string $name)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.countryCode = :countryCode')
            ->andWhere('m.name = :name')
            ->setParameter('countryCode', $countryCode)
            ->setParameter('name', $name)
        ;

        $query = $qb->getQuery();
        $result = $query->getOneOrNullResult();
        return $result;
    }
}
