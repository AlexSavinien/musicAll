<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Place;
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

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
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

    /**
     * @param $research
     * @return mixed
     *
     * Sert à rechercher les 50 événements qui correspondent à la recherche.
     * La recherche se fait par artiste, ou nom, ou lieu, ou style
     */
    public function findEvent($research)
    {
        $qb = $this->createQueryBuilder('e');
        $cnx = $this->getEntityManager()->getConnection();

        return $qb
            ->join('e.place', 'p')
            ->orWhere('e.artist LIKE ' . $cnx->quote('%'.$research.'%'))
            ->orWhere('e.name LIKE ' . $cnx->quote('%'.$research.'%'))
            ->orWhere('p.name LIKE ' . $cnx->quote('%'.$research.'%'))
            ->orWhere('e.style LIKE ' . $cnx->quote('%'.$research.'%'))
            ->orWhere('e.eventDate LIKE' . $cnx->quote('%'.$research.'%'))
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }


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
