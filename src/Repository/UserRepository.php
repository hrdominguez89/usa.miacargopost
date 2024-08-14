<?php

namespace App\Repository;

use App\Entity\User;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, PaginationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $entity
     * @param bool $flush
     *
     * @return void
     */
    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    /**
     * @param User $entity
     * @param bool $flush
     *
     * @return void
     */
    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

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

        $dql = "SELECT e.id, e.name, e.email, e.roles, e.dateCreated, e.dateUpdated FROM App\Entity\User e ";

        if ($s['value']) {
            $dql = $dql." WHERE (LOWER(e.name) LIKE LOWER(:filter) OR LOWER(e.email) LIKE LOWER(:filter) OR LOWER(e.roles) LIKE LOWER(:filter)) ";
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
