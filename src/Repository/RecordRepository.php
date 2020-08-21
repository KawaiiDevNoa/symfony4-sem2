<?php

namespace App\Repository;

use App\Entity\Record;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Record|null find($id, $lockMode = null, $lockVersion = null)
 * @method Record|null findOneBy(array $criteria, array $orderBy = null)
 * @method Record[]    findAll()
 * @method Record[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    // /**
    //  *Nouveautés: albums de sortis il y a moins d'un mois
    //  */
    
    public function findNews()
    {
        return $this->createQueryBuilder('r') // r = alias de record
            ->where('r.releaseAt >= :last_month')
            ->setParameter('last_month', new \DateTime('-1 month'))
            ->orderBy('r.releaseAt','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    

    /*
    public function findOneBySomeField($value): ?Record
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
