<?php

namespace App\Repository;

use App\Entity\Reminder;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Reminder>
 *
 * @method Reminder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reminder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reminder[]    findAll()
 * @method Reminder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReminderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reminder::class);
    }

    public function save(Reminder $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reminder $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param UserInterface|null $user
     * @param \DateTime $start
     * @param \DateTime $end
     * @param int|null $limit
     * @return array
     */
    public function findAllPaginated(?UserInterface $user, \DateTime $start, \DateTime $end, ?int $limit = 100): array
    {
        $dql = "SELECT e FROM App\Entity\Reminder e LEFT JOIN e.user u WHERE e.dateStart BETWEEN :startStr AND :endStr ";

        if ($user instanceof User) {
            $dql = $dql." AND u.id =:id ";
        }

        $dql = $dql." ORDER BY e.id ASC";

        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('startStr', $start->format('Y-m-d 00:00:01'))
            ->setParameter('endStr', $end->format('Y-m-d 23:59:59'));

        if ($user instanceof User) {
            $query->setParameter('id', $user->getId());
        } else {
            $query->setMaxResults($limit);
        }

        /** @var Reminder[] $events */
        $events = $query->getResult();

        $response = [];

        foreach ($events as $event) {
            $response[] = $event->toArray();
        }

        return $response;
    }

    /**
     * @param $request
     * @return array
     */
    public function parseDates($request): array
    {
        [$start, $end] = [$request->get('start'), $request->get('end')];

        if ($start && $end) {
            try {
                [$start, $end] = [new \DateTime($start), new \DateTime($end)];
            } catch (\Exception) {
                [$start, $end] = [new \DateTime('first day of this month'), new \DateTime('last day of this month')];
            }
        }

        return [$start, $end];
    }
}
