<?php

namespace OC\PlatformBundle\Repository;
use \Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Types\IntegerType;

class ApplicationRepository extends EntityRepository
{
    public function getApplicationsWithAdvert($limit){
            return $this->createQueryBuilder('app')
            ->innerJoin('app.advert', 'a')
            ->addSelect('a')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
