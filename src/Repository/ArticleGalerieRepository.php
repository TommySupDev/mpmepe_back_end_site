<?php

namespace App\Repository;

use App\Entity\ArticleGalerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleGalerie>
 *
 * @method ArticleGalerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleGalerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleGalerie[]    findAll()
 * @method ArticleGalerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleGalerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleGalerie::class);
    }

//    /**
//     * @return ArticleGalerie[] Returns an array of ArticleGalerie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArticleGalerie
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
