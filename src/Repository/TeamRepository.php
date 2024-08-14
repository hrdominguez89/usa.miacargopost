<?php

namespace App\Repository;

use App\Entity\Team;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    ////////////////////
    ///
    /// OWN METHODS
    ///
    ////////////////////

    public function findAllPaginated($c, $o, $s, $l = 100, $p = 1): PaginationInterface
    {

        $dql = "SELECT e.id, e.name, e.dateCreated, e.dateUpdated, COUNT(u.id) as users FROM App\Entity\Team e LEFT JOIN e.users u ";

        if ($s['value']) {
            $dql = $dql." WHERE (LOWER(e.name) LIKE LOWER(:filter)) ";
        }

        $dql = $dql." GROUP BY e.id ORDER BY e.".($c[$o[0]['column']]['data'].' '.$o[0]['dir']);

        $query = $this->getEntityManager()->createQuery($dql);

        if ($s['value']) {
            $query->setParameter('filter', '%'.$s['value'].'%');
        }

        return $this->paginator->paginate($query, $p, $l);
    }


    /**
     * @param $tId
     * @return float|int|array|string
     */
    public function findAllMembersPaginated($tId): array|float|int|string
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                "SELECT e.id, e.name, e.email, e.roles, e.dateCreated 
                FROM App\Entity\User e 
                LEFT JOIN e.team t 
                WHERE t.id =:id
                GROUP BY e.id ORDER BY e.id"
            )->setParameter('id', $tId)->getArrayResult();
    }
}
