<?php

namespace App\Repository;

use App\Entity\Meal;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Meal>
 *
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginationInterface)
    {
        parent::__construct($registry, Meal::class);
    }

    public function save(Meal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Meal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     /**
      * Get published meal thanks to search Data value
      * @param SearchData $searchData
      * @return PaginationInterface
      */

    public function findBySearch(SearchData $searchData)
    {
        $data = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.name LIKE :chaine')
            ->orWhere('r.description LIKE :chaine')
            ->setParameter('chaine', '%'.$searchData->query.'%');

        if(!empty($searchData->query)) {
            //Search on meals title
        $data = $data
                    ->andWhere("r.name LIKE :chaine")
                    // The names of the agencies are retrieved
                    ->join('r.id_agency', 'a')
                    ->orWhere("a.name LIKE :chaine")
                    // The names of the categories are retrieved
                    ->join('r.id_category', 'c')
                    ->orWhere("c.name LIKE :chaine")
                    ->setParameter('chaine', "%{$searchData->query }%" );
        }
        $data = $data
                    ->getQuery()
                    ->getResult();

        $posts = $this->paginationInterface->paginate($data, $searchData->page, 12);
        
        return $posts;
    }

//    /**
//     * @return Meal[] Returns an array of Meal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Meal
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
