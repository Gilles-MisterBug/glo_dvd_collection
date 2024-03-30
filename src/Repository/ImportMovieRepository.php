<?php

namespace App\Repository;

use App\Entity\ImportMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<ImportMovie>
 *
 * @method ImportMovie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImportMovie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImportMovie[]    findAll()
 * @method ImportMovie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportMovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, ImportMovie::class);
    }


    /**
     * @param int $page
     * @param int $limit
     * @return PaginationInterface Returns an array of ImportMovie objects
     */
    public function paginator(int $page, int $limit): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->buildMovies(),
            $page,
            $limit,
            [
                'distinct' => true,
                'pageOutOfRange' => 'fix',
                'sortFieldAllowList' => ['i.id', 'i.title', 'i.originalTitle', 'i.support'],
                'defaultSortFieldName' => ['i.title'],
                'defaultSortDirection' => 'asc',
                'wrap-queries' => true,
                'defaultFilterFields' => ['i.support', 'i.title'],
            ]
        );
    }

    /**
     * @return QueryBuilder Returns an array of ImportMovie objects
     */
    public function buildMovies(): QueryBuilder
    {
        return $this->createQueryBuilder('i')
        ;
    }

    public function getMovies(): array
    {
        return $this->buildMovies()->getQuery()->getResult();
    }

//    /**
//     * @return ImportMovie[] Returns an array of ImportMovie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImportMovie
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
