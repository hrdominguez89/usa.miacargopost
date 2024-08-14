<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Package;
use App\Entity\PaymentType;
use App\Entity\Product;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param Order $entity
     * @param bool $flush
     * @return void
     */
    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
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


    /**
     * @param $orderId
     * @return Order|null
     */
    public function findOneByOrderId($orderId): ?Order
    {
        return $this->findOneBy(['orderId' => $orderId]);
    }

    public function findAllPaginated($c, $o, $s, $l = 100, $p = 1): PaginationInterface
    {

        $dql = "SELECT e.id, e.orderId, e.dateCreated, e.dateUpdated, e.shippingCost, e.productDiscountRD, e.productDiscountUSD, e.statusOrder, e.inventoryId,
                c.id as customer_id, c.apiId as customer_api_id, c.name, c.email, c.phone, c.customerType,
                i.id as invoice_id, i.statusInvoice as status_invoice, i.paymentDeadlineInvoice,
                p.id as payment_id, p.name as payment_name
                FROM App\Entity\Order e 
                LEFT JOIN e.customer c 
                LEFT JOIN App\Entity\PaymentType p WITH p.id = e.payment_type
                LEFT JOIN e.invoice i ";

        if ($s['value']) {
            $dql = $dql . " WHERE (LOWER(c.orderId) LIKE LOWER(:filter) OR LOWER(e.inventoryId) LIKE LOWER(:filter) 
            OR LOWER(c.name) LIKE LOWER(:filter) OR LOWER(c.email) LIKE LOWER(:filter) 
            OR LOWER(c.phone) LIKE LOWER(:filter) OR LOWER(c.cellPhone) LIKE LOWER(:filter) 
            OR LOWER(c.customerType) LIKE LOWER(:filter) OR LOWER(e.orderId) LIKE LOWER(:filter)) ";
        }

        if (in_array($c[$o[0]['column']]['data'], ['name', 'email', 'phone', 'customerType'])) {
            $dql = $dql . " ORDER BY c." . ($c[$o[0]['column']]['data'] . ' ' . $o[0]['dir']);
        } else {
            $dql = $dql . " ORDER BY e." . ($c[$o[0]['column']]['data'] . ' ' . $o[0]['dir']);
        }

        $query = $this->getEntityManager()->createQuery($dql);

        if ($s['value']) {
            $query->setParameter('filter', '%' . $s['value'] . '%');
        }

        return $this->paginator->paginate($query, $p, $l);
    }

    /**
     * @param array $raw
     * @return Order
     */
    public function createAPIOrder(array $raw): Order
    {
        $order = new Order();

        $customer = $this->getEntityManager()->getRepository(Customer::class)->findOneBy(
            ['apiId' => $raw['customer']['id']]
        );

        $paymentType = $this->getEntityManager()->getRepository(PaymentType::class)->find($raw['payment_type_id']);

        $order
            ->setCustomer($customer) // for status 201
            ->setOrderId($raw['order_id'] ?? null) // for status 201
            ->setOrderDC($raw['created_at'] ?? null) // for status 201
            ->setWareHouseId($raw['warehouse_id'] ?? null); // for status 201

        $order
            ->setStatusOrder($raw['status_order'] ?? $order->getStatusOrder())
            ->setShippingInternational($raw['international_shipping'] ?? $order->getShippingInternational())
            ->setShipping($raw['shipping'] ?? $order->getShipping())
            ->setBillFile($raw['proforma_bill_file'] ?? $order->getBillFile())
            ->setPaymentFiles($raw['payments_files'] ?? [])
            ->setPaymentsReceivedFile($raw['payments_received_files'] ?? [])
            ->setPaymentsTransactionCodes($raw['payments_trasaction_codes'] ?? [])
            ->setDebitCreditNotesFile($raw['debit_credit_notes_files'] ?? []);

        // SHIPPING

        $order
            ->setShippingName($raw['receiver']['name'] ?? null)
            ->setShippingDocumentType($raw['receiver']['document_type'] ?? null)
            ->setShippingDocument($raw['receiver']['document'] ?? null)
            ->setShippingPhoneCell($raw['receiver']['phone_cell'] ?? null)
            ->setShippingPhoneHome($raw['receiver']['phone_home'] ?? null)
            ->setShippingEmail($raw['receiver']['email'] ?? null)
            ->setShippingCountry($raw['receiver']['country_id'] ?? null)
            ->setShippingCountryName($raw['receiver']['country_name'] ?? null)
            ->setShippingState($raw['receiver']['state_id'] ?? null)
            ->setShippingStateName($raw['receiver']['state_name'] ?? null)
            ->setShippingCity($raw['receiver']['city_id'] ?? null)
            ->setShippingCityName($raw['receiver']['city_name'] ?? null)
            ->setShippingAddress($raw['receiver']['address'] ?? null)
            ->setShippingPostalCode($raw['receiver']['cod_zip'] ?? null)
            ->setShippingAddInfo($raw['receiver']['additional_info'] ?? null);

        // BILL

        $order
            ->setBillAddressId($raw['bill_address']['bill_address_id'] ?? null)
            ->setBillName($raw['bill_address']['bill_name'] ?? null)
            ->setBillIdentityType($raw['bill_address']['bill_identity_type'] ?? null)
            ->setBillIdentityNumber($raw['bill_address']['bill_identity_number'] ?? null)
            ->setBillCountry($raw['bill_address']['country_id'] ?? null)
            ->setBillCountryName($raw['bill_address']['country_name'] ?? $customer->getBillCountryName())
            ->setBillState($raw['bill_address']['state_id'] ?? null)
            ->setBillStateName($raw['bill_address']['state_name'] ?? $customer->getBillStateName())
            ->setBillCity($raw['bill_address']['city_id'] ?? null)
            ->setBillCityName($raw['bill_address']['city_name'] ?? $customer->getBillCityName())
            ->setBillAddress($raw['bill_address']['address'] ?? null);

        // PRODUCTS

        $productsRD = $raw['itemsRD'] ?? [];
        $productsUSD = $raw['itemsUSD'] ?? [];

        if (count($productsRD) > 0 || count($productsUSD) > 0) {
            $order->getProducts()->clear();
        }

        foreach ($productsRD as $p) {

            $currency = $this->getEntityManager()->getRepository(Currency::class)->find($p['currency_id']);
            
            $product = new Product();
            $product
                ->setProductId($p['product_id'] ?? $product->getProductId())
                ->setProductId3Pl($p['product_id'] ?? $product->getProductId3Pl())
                ->setName($p['product_name'] ?? $product->getName())
                ->setWeight($p['weight'] ?? $product->getWeight())
                ->setCost($p['price'] ?? $product->getCost())
                ->setDiscount($p['discount'] ?? $product->getDiscount())
                ->setQuantity($p['qty'] ?? $product->getQuantity())
                ->setCurrency($currency)
                ->setOrder($order);
        }

        foreach ($productsUSD as $p) {
            $currency = $this->getEntityManager()->getRepository(Currency::class)->find($p['currency_id']);

            $product = new Product();

            $product
                ->setProductId($p['product_id'] ?? $product->getProductId())
                ->setProductId3Pl($p['product_id'] ?? $product->getProductId3Pl())
                ->setName($p['product_name'] ?? $product->getName())
                ->setWeight($p['weight'] ?? $product->getWeight())
                ->setCost($p['price'] ?? $product->getCost())
                ->setDiscount($p['discount'] ?? $product->getDiscount())
                ->setQuantity($p['qty'] ?? $product->getQuantity())
                ->setCurrency($currency)
                ->setOrder($order);
        }

        // PACKAGES

        $packages = $raw['packages'] ?? [];

        if (count($packages) > 0) {
            $order->getPackages()->clear();
        }

        foreach ($packages as $p) {

            if (isset($p['lb'])) {

                $package = new Package();

                $package
                    ->setLb($p['lb'])
                    ->setHeight($p['height'] ?? null)
                    ->setWidth($p['width'] ?? null)
                    ->setDepth($p['depth'] ?? null)
                    ->setCourierId($p['courier_id'] ?? null)
                    ->setCourierName($p['courier_name'] ?? null)
                    ->setServiceId($p['service_id'] ?? null)
                    ->setServiceName($p['service_name'] ?? null)
                    ->setGuideNumber($p['guide_number'] ?? null)
                    ->setOrder($order);
            }
        }

        $order
            ->setSubTotalRD($raw['subtotal_rd'] ?? $order->getSubTotalRD())
            ->setProductDiscountRD($raw['total_product_discount_rd'] ?? $order->getProductDiscountRD())
            ->setTaxRD($raw['tax_rd'] ?? $order->getTaxRD())
            ->setTotalOrderRD($raw['total_order_rd'] ?? $order->getTotalOrderRD())
            
            ->setSubTotalUSD($raw['subtotal_usd'] ?? $order->getSubTotalUSD())
            ->setProductDiscountUSD($raw['total_product_discount_usd'] ?? $order->getProductDiscountUSD())
            ->setTaxUSD($raw['tax_usd'] ?? $order->getTaxUSD())
            ->setTotalOrderUSD($raw['total_order_usd'] ?? $order->getTotalOrderUSD())
            

            ->setCodePromoDiscount($raw['promotional_code_discount'] ?? $order->getCodePromoDiscount())
            ->setShippingCost($raw['shipping_cost'] ?? $order->getShippingCost())
            ->setShippinDiscount($raw['shipping_discount'] ?? $order->getShippinDiscount());

        //SETEO TIPO DE PAGO, Y SI MAS INFO SI LA POSEE

        $order
            ->setPaymentType($paymentType)
            ->setCardnetSession($raw['cardnet_session'])
            ->setCardnetSessionKey($raw['cardnet_session_key'])
            ->setCardnetAuthorizationCode($raw['cardnet_authorization_code'])
            ->setCardnetTxToken($raw['cardnet_tx_token'])
            ->setCardnetResponseCode($raw['cardnet_response_code'])
            ->setCardnetCreditcardNumber($raw['cardnet_creditcard_number'])
            ->setCardnetRetrivalReferenceNumber($raw['cardnet_retrival_reference_number'])
            ->setCardnetRemoteResponseCode($raw['cardnet_remote_response_code'])
            ->setFiscalInvoiceRequired($raw['fiscal_invoice_required']);
        return $order;
    }

    /**
     * @param array $raw
     * @return Order|null
     */
    public function updateAPIOrder(array $raw): ?Order
    {
        $order = $this->findOneBy(['inventoryId' => $raw['sales_id'] ?? null]);

        if ($order) {

            $order->setStatusOrder($raw['status_order']);

            $packages = $raw['packages'] ?? [];
            if (count($packages) > 0) {
                $order->getPackages()->clear();
                foreach ($packages as $p) {

                    $package = new Package();
                    $package
                        ->setLb($p['lb'])
                        ->setHeight($p['height'])
                        ->setWidth($p['width'])
                        ->setDepth($p['depth'])
                        ->setCourierId($p['courier_id'])
                        ->setCourierName($p['courier_name'])
                        ->setServiceId($p['service_id'])
                        ->setServiceName($p['service_name'])
                        ->setGuideNumber($p['guide_number'])
                        ->setOrder($order);
                }
            }
        }

        return $order;
    }
}
