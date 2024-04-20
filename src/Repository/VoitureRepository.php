<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\ORM\Query;
use App\Entity\RechercherVoiture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


/**
 * @extends ServiceEntityRepository<Voiture>
 *
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function findAllWithPagination(RechercherVoiture $recherche): Query
    {
        $req = $this->createQueryBuilder('v');
        if ($recherche->getAnneeMin()) {
            $req = $req->andWhere("v.annee > :min")
                ->setParameter('min', $recherche->getAnneeMin());
        }
        if ($recherche->getAnneeMax()) {
            $req = $req->andWhere("v.annee < :max")
                ->setParameter("max", $recherche->getAnneeMax());
        }
        dump($req->getQuery()->getSQL());
        return $req->getQuery();
    }

    //    /**
//     * @return Voiture[] Returns an array of Voiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Voiture
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

return static function (ContainerConfigurator $configurator): void {
    $configurator->extension('knp_paginator', [
        'page_range' => 5,
        // number of links shown in the pagination menu (e.g: you have 10 pages, a page_range of 3, on the 5th page you'll see links
        'default_options' => [
            'page_name' => 'page',
            // page query parameter name
            'sort_field_name' => 'sort',
            // sort field query parameter name
            'sort_direction_name' => 'direction',
            // sort direction query parameter name
            'distinct' => true,
            // ensure distinct results, useful when ORM queries are using GROUP BY statements
            'filter_field_name' => 'filterField',
            // filter field query parameter name
            'filter_value_name' => 'filterValue' // filter value query parameter name
        ],
        'template' => [
            'pagination' => '@KnpPaginator/Pagination/sliding.html.twig',
            // sliding pagination controls template
            'sortable' => '@KnpPaginator/Pagination/sortable_link.html.twig',
            // sort link template
            'filtration' => '@KnpPaginator/Pagination/filtration.html.twig' // filters template
        ]
    ]);
};

