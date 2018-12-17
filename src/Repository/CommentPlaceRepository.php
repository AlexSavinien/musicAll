<?php

namespace App\Repository;

use App\Entity\CommentPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommentPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentPlace[]    findAll()
 * @method CommentPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentPlaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommentPlace::class);
    }

    // /**
    //  * @return CommentPlace[] Returns an array of CommentPlace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentPlace
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
