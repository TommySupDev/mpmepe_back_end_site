<?php

namespace App\Repository;

use App\Entity\PrestationDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrestationDetail>
 *
 * @method PrestationDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrestationDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrestationDetail[]    findAll()
 * @method PrestationDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrestationDetail::class);
    }

//    /**
//     * @return PrestationDetail[] Returns an array of PrestationDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PrestationDetail
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
