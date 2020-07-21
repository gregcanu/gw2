<?php

namespace App\Repository;

use App\Entity\Farm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Farm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Farm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Farm[]    findAll()
 * @method Farm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FarmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Farm::class);
    }
    
    public function findAllFarm() {
        $farms = $this->createQueryBuilder('f')
                        ->where('f.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('f.sort')
                        ->getQuery()
                        ->getResult()
        ;
        
        foreach ($farms as $farm) {
            $farm->getItem()->getName();
        }
        
        return $farms;
    }
    
    public function getLastSortValue() {
        $value = $this->createQueryBuilder('f')
                ->select('MAX(f.sort) as max_sort')
                        ->getQuery()
                        ->getResult()
        ;
        
        return $value[0]['max_sort'];
    }

    // /**
    //  * @return Farm[] Returns an array of Farm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Farm
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
