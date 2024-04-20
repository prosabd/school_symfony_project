<?php

namespace App\Repository;

use App\Entity\RechercherVoiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RechercherVoiture>
 *
 * @method RechercherVoiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method RechercherVoiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method RechercherVoiture[]    findAll()
 * @method RechercherVoiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RechercherVoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RechercherVoiture::class);
    }

//    /**
//     * @return RechercherVoiture[] Returns an array of RechercherVoiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RechercherVoiture
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
