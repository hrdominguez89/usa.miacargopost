<?php

namespace App\Repository;

use App\Entity\Role;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Role>
 *
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * @param Role $entity
     * @param bool $flush
     *
     * @return void
     */
    public function save(Role $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Role $entity, bool $flush = false): void
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

        $dql = "SELECT e.id, e.roleKey, e.name, e.dateCreated, e.dateUpdated FROM App\Entity\Role e ";

        if ($s['value']) {
            $dql = $dql." WHERE (LOWER(e.roleKey) LIKE LOWER(:filter) OR LOWER(e.name) LIKE LOWER(:filter)) ";
        }

        /** @noinspection DuplicatedCode */
        $dql = $dql." ORDER BY e.".($c[$o[0]['column']]['data'].' '.$o[0]['dir']);

        $query = $this->getEntityManager()->createQuery($dql);

        if ($s['value']) {
            $query->setParameter('filter', '%'.$s['value'].'%');
        }

        return $this->paginator->paginate($query, $p, $l);
    }
}
