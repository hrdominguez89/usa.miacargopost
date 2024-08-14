<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @param Customer $entity
     * @param bool $flush
     * @return void
     */
    public function save(Customer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Customer $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Customer $entity, bool $flush = false): void
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

        $dql = "SELECT e.id, e.apiId,
                e.billAddressId, e.billCountry, e.billState, e.billCity, e.billAddress, e.billPostalCode, e.billAddInfo,
                e.homeAddressId, e.homeCountry, e.homeState, e.homeCity, e.homeAddress, e.homePostalCode, e.homeAddInfo,
                e.email, e.dateCreated, e.phone, e.cellPhone, e.birthDay, e.name, e.lastName, e.status, e.gender, e.customerType, e.dateUpdated
                FROM App\Entity\Customer e ";

        if ($s['value']) {
            $dql = $dql . " WHERE (LOWER(e.name) LIKE LOWER(:filter) OR LOWER(e.email) LIKE LOWER(:filter) 
            OR LOWER(e.phone) LIKE LOWER(:filter) OR LOWER(e.cellPhone) LIKE LOWER(:filter) 
            OR LOWER(e.lastName) LIKE LOWER(:filter) OR LOWER(e.gender) LIKE LOWER(:filter)
            OR LOWER(e.customerType) LIKE LOWER(:filter) OR LOWER(e.apiId) LIKE LOWER(:filter) OR LOWER(e.id) LIKE LOWER(:filter)) ";
        }

        /** @noinspection DuplicatedCode */
        $dql = $dql . " ORDER BY e." . ($c[$o[0]['column']]['data'] . ' ' . $o[0]['dir']);

        $query = $this->getEntityManager()->createQuery($dql);

        if ($s['value']) {
            $query->setParameter('filter', '%' . $s['value'] . '%');
        }

        return $this->paginator->paginate($query, $p, $l);
    }

    /**
     * @param array $raw
     * @return array
     */
    public function createAPICustomer(array $raw): array
    {
        $customer = $this->findOneBy(['apiId' => $raw['id'] ?? null]);

        if ($customer) {
            return $this->updateAPICustomer($customer, $raw);
        }

        $customer = new Customer();

        $customer
            ->setApiId($raw['id'] ?? null)
            ->setEmail($raw['email'] ?? null)
            ->setName($raw['name'] ?? null)
            ->setLastName($raw['lastname'] ?? null)
            ->setPhone($raw['phone'] ?? null)
            ->setCellPhone($raw['cel_phone'] ?? null)
            ->setCustomerType($raw['customer_type'] ?? null)
            ->setStatus($raw['status'] ?? null)
            ->setGender($raw['gender'] ?? null)
            ->setCustomerTypeRole($raw['customer_type_role'] ?? null)
            ->setIdentityType($raw['identity_type'] ?? null)
            ->setIdentityNumber($raw['identity_number'] ?? null)
            ->setPhoneCode($raw['country_phone_code'] ?? null)
            ->setDataJson($raw);

        if (isset($raw['birth_day'])) {
            try {
                $birthday = new \DateTime($raw['birth_day']);
                $customer->setBirthDay($birthday);
            } catch (\Exception) {
            }
        }

        if (isset($raw['home_address']) && is_array($raw['home_address'])) {
            $customer
                ->setHomeAddressId($raw['home_address']['home_address_id'] ?? null)
                ->setHomeCountry($raw['home_address']['Country'] ?? null)
                ->setHomeState($raw['home_address']['State'] ?? null)
                ->setHomeCity($raw['home_address']['City'] ?? null)
                ->setHomeAddress($raw['home_address']['address'] ?? null)
                ->setHomePostalCode($raw['home_address']['postal_code'] ?? null)
                ->setHomeAddInfo($raw['home_address']['aditional_info'] ?? null);
        }

        if (isset($raw['bill_address']) && is_array($raw['bill_address'])) {
            $customer
                ->setBillAddressId($raw['bill_address']['bill_address_id'] ?? null)
                ->setBillName($raw['bill_address']['bill_name'] ?? null)
                ->setBillCountry($raw['bill_address']['Country'] ?? null)
                ->setBillState($raw['bill_address']['State'] ?? null)
                ->setBillCity($raw['bill_address']['City'] ?? null)
                ->setBillAddress($raw['bill_address']['address'] ?? null)
                ->setBillPostalCode($raw['bill_address']['postal_code'] ?? null)
                ->setBillAddInfo($raw['bill_address']['aditional_info'] ?? null);
        }

        return [$customer, 201];
    }

    /**
     * @param Customer $customer
     * @param array $raw
     * @return array
     */
    public function updateAPICustomer(Customer $customer, array $raw): array
    {
        $customer
            ->setEmail($raw['email'] ?? $customer->getEmail())
            ->setName($raw['name'] ?? $customer->getName())
            ->setLastName($raw['lastname'] ?? $customer->getLastName())
            ->setPhone($raw['phone'] ?? $customer->getPhone())
            ->setCellPhone($raw['cel_phone'] ?? $customer->getCellPhone())
            ->setCustomerType($raw['customer_type'] ?? $customer->getCustomerType())
            ->setStatus($raw['status'] ?? $customer->getStatus())
            ->setGender($raw['gender'] ?? $customer->getGender())
            ->setCustomerTypeRole($raw['customer_type_role'] ?? $customer->getCustomerTypeRole())
            ->setIdentityType($raw['identity_type'] ?? $customer->getIdentityType())
            ->setIdentityNumber($raw['identity_number'] ?? $customer->getIdentityNumber())
            ->setPhoneCode($raw['country_phone_code'] ?? $customer->getPhoneCode())
            ->setDateUpdated(new \DateTime())
            ->setDataUpdateJson($raw);

        if (isset($raw['home_address']) && is_array($raw['home_address'])) {
            $customer
                ->setHomeAddressId($raw['home_address']['home_address_id'] ?? $customer->getHomeAddressId())
                ->setHomeCountry($raw['home_address']['Country'] ?? $customer->getHomeCountry())
                ->setHomeState($raw['home_address']['State'] ?? $customer->getHomeState())
                ->setHomeCity($raw['home_address']['City'] ?? $customer->getHomeCity())
                ->setHomeAddress($raw['home_address']['address'] ?? $customer->getHomeAddress())
                ->setHomePostalCode($raw['home_address']['postal_code'] ?? $customer->getHomePostalCode())
                ->setHomeAddInfo($raw['home_address']['aditional_info'] ?? $customer->getHomeAddInfo());
        }

        if (isset($raw['bill_address']) && is_array($raw['bill_address'])) {
            $customer
                ->setBillAddressId($raw['bill_address']['bill_address_id'] ?? $customer->getBillAddressId())
                ->setBillName($raw['bill_address']['bill_name'] ?? $customer->getBillName())
                ->setBillCountry($raw['bill_address']['Country'] ?? $customer->getBillCountry())
                ->setBillState($raw['bill_address']['State'] ?? $customer->getBillState())
                ->setBillCity($raw['bill_address']['City'] ?? $customer->getBillCity())
                ->setBillAddress($raw['bill_address']['address'] ?? $customer->getBillAddress())
                ->setBillPostalCode($raw['bill_address']['postal_code'] ?? $customer->getBillPostalCode())
                ->setBillAddInfo($raw['bill_address']['aditional_info'] ?? $customer->getBillAddInfo());
        }

        return [$customer, 200];
    }
}
