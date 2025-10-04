<?php

namespace App\Repository;

use App\Entity\Annale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annale>
 */
class AnnaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annale::class);
    }

    public function findDistinctNiveauxByFormation(int $formationId): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT n')
            ->join('a.niveau', 'n')
            ->where('a.formation = :formationId')
            ->setParameter('formationId', $formationId)
            ->getQuery()
            ->getResult();
    }

    public function findDistinctMatieresByFormationAndNiveau(int $formationId, int $niveauId): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT m')
            ->join('a.matiere', 'm')
            ->where('a.formation = :formationId')
            ->andWhere('a.niveau = :niveauId')
            ->setParameter('formationId', $formationId)
            ->setParameter('niveauId', $niveauId)
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Annale[] Returns an array of Annale objects
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

    //    public function findOneBySomeField($value): ?Annale
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
