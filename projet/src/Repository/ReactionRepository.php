<?php

namespace App\Repository;

use App\Entity\Reaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reaction[]    findAll()
 * @method Reaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reaction::class);
    }
    /**
     * @return Reaction réaction correspondante
     */
    public function findOne(int $sujet_id, int $user_id): ?Reaction
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.auteur = :auteur')
            ->andWhere('r.sujet = :sujet')
            ->setParameter('auteur',$user_id)
            ->setParameter('sujet',$sujet_id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getLikes(int $sujet_id){
        $qb = $this->createQueryBuilder('r');

        return $qb->select($qb->expr()->count('r'))
            ->where('r.sujet = :sujet')
            ->andWhere('r.etat = 1')
            ->setParameter('sujet',$sujet_id)
            ->getQuery()
            ->getSingleScalarResult();
    }   
    
    public function getDislikes(int $sujet_id){
        $qb = $this->createQueryBuilder('r');

        return $qb->select($qb->expr()->count('r'))
            ->where('r.sujet = :sujet')
            ->andWhere('r.etat = 0')
            ->setParameter('sujet',$sujet_id)
            ->getQuery()
            ->getSingleScalarResult();
    }
    // /**
    //  * @return Reaction[] Returns an array of Reaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reaction
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
