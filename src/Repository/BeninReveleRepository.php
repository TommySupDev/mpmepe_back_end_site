<?php

namespace App\Repository;

use App\Entity\BeninRevele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BeninRevele>
 *
 * @method BeninRevele|null find($id, $lockMode = null, $lockVersion = null)
 * @method BeninRevele|null findOneBy(array $criteria, array $orderBy = null)
 * @method BeninRevele[]    findAll()
 * @method BeninRevele[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeninReveleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeninRevele::class);
    }

//    /**
//     * @return BeninRevele[] Returns an array of BeninRevele objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BeninRevele
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
