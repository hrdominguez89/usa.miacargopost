<?php

namespace App\Repository;

use App\Entity\Invoice;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Invoice>
 *
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * @param Invoice $entity
     * @param bool $flush
     * @return void
     */
    public function save(Invoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Invoice $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Invoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllPaginated($c, $o, $s, $l = 100, $p = 1): PaginationInterface
    {

        $dql = "SELECT e.id, e.dateCreated, e.employeeName, e.statusInvoice, e.totalRD, e.partialRD, e.deudaRD, e.totalUSD, e.partialUSD, e.deudaUSD, e.paymentDeadlineInvoice,
                c.id as customerId, c.name as customerName, c.email as customerEmail,
                o.id as orderId, o.orderId as orderAppId,
                p.id as payment_id, p.name as payment_name
                FROM App\Entity\Invoice e 
                LEFT JOIN e.order o 
                LEFT JOIN App\Entity\PaymentType p WITH p.id = o.payment_type
                LEFT JOIN o.customer c ";

        if ($s['value']) {
            $dql = $dql." WHERE (LOWER(e.employeeName) LIKE LOWER(:filter) OR LOWER(o.statusInvoice) LIKE LOWER(:filter) OR LOWER(e.paymentDeadlineInvoice) LIKE LOWER(:filter)) ";
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
