<?php

namespace App\Repository;

use App\Entity\AssignSalesman;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssignSalesman>
 */
class AssignSalesmanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignSalesman::class);
    }

    function _get_business_source($limit, $start, $st = null) {
        $builder = $this->createQueryBuilder('bs')
            ->andWhere('bs.company_id = :company_id')
            ->setParameter('company_id', auth()->user()->company_id)
            ->orderBy('bs.name', 'asc');

        if ($st) {
            $builder->andWhere('name LIKE :name', $st)
                ->setParameter('name', "%$st%");
        }

        $builder->setMaxResults($limit)->setFirstResult($start);
        return $builder->getQuery()->getArrayResult();
    }

    //    /**
    //     * @return AssignSalesman[] Returns an array of AssignSalesman objects
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

    //    public function findOneBySomeField($value): ?AssignSalesman
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
