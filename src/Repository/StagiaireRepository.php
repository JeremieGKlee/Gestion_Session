<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

    /**
     * @return Stagiaire[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }



    // /**
    //  * @return Stagiaire[] Returns an array of Stagiaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stagiaire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
