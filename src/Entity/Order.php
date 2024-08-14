<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`tb_order`')]
#[UniqueEntity('orderId')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'team_id', referencedColumnName: 'id', nullable: true)]
    private ?Team $team = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Customer $customer = null;

    #[ORM\OneToOne(mappedBy: 'order', targetEntity: Invoice::class)]
    private ?Invoice $invoice = null;

    #[ORM\Column(name: 'order_id', type: Types::STRING, length: 100, unique: true)]
    #[Assert\Length(max: 100)]
    private ?string $orderId = null;

    #[ORM\Column(name: 'status_order', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $statusOrder = null;

    #[ORM\Column(name: 'ware_house_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $wareHouseId = null;

    #[ORM\Column(name: 'inventory_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $inventoryId = null;

    #[ORM\Column(name: 'shipping_international', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingInternational = null;

    #[ORM\Column(name: 'shipping', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shipping = null;

    #[ORM\Column(name: 'bill_file', type: Types::TEXT, nullable: true)]
    private ?string $billFile = null;

    #[ORM\Column(name: 'payments_files', type: Types::JSON, nullable: true)]
    private ?array $paymentFiles;

    #[ORM\Column(name: 'payments_received_file', type: Types::JSON, nullable: true)]
    private ?array $paymentsReceivedFile = null;

    #[ORM\Column(name: 'debit_credit_notes_files', type: Types::JSON, nullable: true)]
    private ?array $debitCreditNotesFile = null;

    #[ORM\Column(name: 'payments_transaction_codes', type: Types::JSON, nullable: true)]
    private ?array $paymentsTransactionCodes = null;

    #[ORM\Column(name: 'shipping_name', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingName = null;

    #[ORM\Column(name: 'shipping_document_type', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingDocumentType = null;

    #[ORM\Column(name: 'shipping_document', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingDocument = null;

    #[ORM\Column(name: 'shipping_phone_cell', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingPhoneCell = null;

    #[ORM\Column(name: 'shipping_phone_home', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingPhoneHome = null;

    #[ORM\Column(name: 'shipping_email', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingEmail = null;

    #[ORM\Column(name: 'shipping_country', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingCountry = null;

    #[ORM\Column(name: 'shipping_country_name', type: Types::STRING, nullable: true)]
    private ?string $shippingCountryName = null;

    #[ORM\Column(name: 'shipping_state', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingState = null;

    #[ORM\Column(name: 'shipping_state_name', type: Types::STRING, nullable: true)]
    private ?string $shippingStateName = null;

    #[ORM\Column(name: 'shipping_city', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingCity = null;

    #[ORM\Column(name: 'shipping_city_name', type: Types::STRING, nullable: true)]
    private ?string $shippingCityName = null;

    #[ORM\Column(name: 'shipping_address', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $shippingAddress = null;

    #[ORM\Column(name: 'shipping_postal_code', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $shippingPostalCode = null;

    #[ORM\Column(name: 'shipping_add_info', type: Types::TEXT, nullable: true)]
    private ?string $shippingAddInfo = null;

    #[ORM\Column(name: 'bill_address_id', type: Types::STRING, nullable: true)]
    private ?string $billAddressId = null;

    #[ORM\Column(name: 'bill_name', type: Types::STRING, nullable: true)]
    private ?string $billName = null;

    #[ORM\Column(name: 'bill_identity_type', type: Types::STRING, nullable: true)]
    private ?string $billIdentityType = null;

    #[ORM\Column(name: 'bill_identity_number', type: Types::STRING, nullable: true)]
    private ?string $billIdentityNumber = null;

    #[ORM\Column(name: 'bill_country', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $billCountry = null;

    #[ORM\Column(name: 'bill_country_name', type: Types::STRING, nullable: true)]
    private ?string $billCountryName = null;

    #[ORM\Column(name: 'bill_state', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $billState = null;

    #[ORM\Column(name: 'bill_state_name', type: Types::STRING, nullable: true)]
    private ?string $billStateName = null;

    #[ORM\Column(name: 'bill_city', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $billCity = null;

    #[ORM\Column(name: 'bill_city_name', type: Types::STRING, nullable: true)]
    private ?string $billCityName = null;

    #[ORM\Column(name: 'bill_address', type: Types::TEXT, nullable: true)]
    private ?string $billAddress = null;

    #[ORM\Column(name: 'bill_postal_code', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $billPostalCode = null;

    #[ORM\Column(name: 'bill_add_info', type: Types::TEXT, nullable: true)]
    private ?string $billAddInfo = null;

    #[ORM\Column(name: 'sub_total_rd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $subTotalRD = null;

    #[ORM\Column(name: 'sub_total_usd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $subTotalUSD = null;

    #[ORM\Column(name: 'product_discount_rd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $productDiscountRD = null;

    #[ORM\Column(name: 'product_discount_usd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $productDiscountUSD = null;

    #[ORM\Column(name: 'code_promo_discount', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $codePromoDiscount = null;

    #[ORM\Column(name: 'tax_rd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $taxRD = null;

    #[ORM\Column(name: 'tax_usd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $taxUSD = null;

    #[ORM\Column(name: 'shipping_cost', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $shippingCost = null;

    #[ORM\Column(name: 'shippingDiscount', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $shippinDiscount = null;

    #[ORM\Column(name: 'order_dc', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $orderDC = null;

    #[ORM\Column(name: 'order_du', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $orderDU = null;

    #[ORM\Column(name: 'total_order_rd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $totalOrderRD = null;

    #[ORM\Column(name: 'total_order_usd', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $totalOrderUSD = null;

    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'date_updated', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdated;

    #[ORM\Column(name: 'data_json', type: Types::JSON, nullable: true)]
    private ?array $dataJson = [];

    #[ORM\Column(name: 'data_update_json', type: Types::JSON, nullable: true)]
    private ?array $dataUpdateJson = [];

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Product::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Package::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $packages;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderHistory::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $orderHistories;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?PaymentType $payment_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardnet_session = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardnet_session_key = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardnet_authorization_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardnet_tx_token = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $cardnet_response_code = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $cardnet_creditcard_number = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $cardnet_retrival_reference_number = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $cardnet_remote_response_code = null;

    #[ORM\Column(nullable: true)]
    private ?bool $fiscal_invoice_required = null;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();

        $this->products = new ArrayCollection();
        $this->packages = new ArrayCollection();
        $this->orderHistories = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Team|null
     */
    public function getTeam(): ?Team
    {
        return $this->team;
    }

    /**
     * @param Team|null $team
     * @return $this
     */
    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return $this
     */
    public function setCustomer(?Customer $customer): Order
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Invoice|null
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param Invoice|null $invoice
     * @return $this
     */
    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @param string|null $orderId
     * @return Order
     */
    public function setOrderId(?string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusOrder(): ?string
    {
        return $this->statusOrder;
    }

    /**
     * @param string|null $statusOrder
     * @return Order
     */
    public function setStatusOrder(?string $statusOrder): self
    {
        $this->statusOrder = match ((int)$statusOrder) {
            1 => 'Open',
            2 => 'Partially Shipped',
            3 => 'Shipped',
            4 => 'Picked',
            5 => 'Packed',
            6 => 'Confirmed',
            7 => 'Canceled',
            default => 'Anulado',
        };

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWareHouseId(): ?string
    {
        return $this->wareHouseId;
    }

    /**
     * @param string|null $wareHouseId
     * @return Order
     */
    public function setWareHouseId(?string $wareHouseId): self
    {
        $this->wareHouseId = $wareHouseId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingInternational(): ?string
    {
        return $this->shippingInternational;
    }

    /**
     * @param string|null $shippingInternational
     * @return Order
     */
    public function setShippingInternational(?string $shippingInternational): self
    {
        $this->shippingInternational = $shippingInternational;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShipping(): ?string
    {
        return $this->shipping;
    }

    /**
     * @param string|null $shipping
     * @return Order
     */
    public function setShipping(?string $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillFile(): ?string
    {
        return $this->billFile;
    }

    /**
     * @param string|null $billFile
     * @return Order
     */
    public function setBillFile(?string $billFile): self
    {
        $this->billFile = $billFile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingName(): ?string
    {
        return $this->shippingName;
    }

    /**
     * @param string|null $shippingName
     * @return $this
     */
    public function setShippingName(?string $shippingName): self
    {
        $this->shippingName = $shippingName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingDocumentType(): ?string
    {
        return $this->shippingDocumentType;
    }

    /**
     * @param string|null $shippingDocumentType
     * @return $this
     */
    public function setShippingDocumentType(?string $shippingDocumentType): self
    {
        $this->shippingDocumentType = $shippingDocumentType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingDocument(): ?string
    {
        return $this->shippingDocument;
    }

    /**
     * @param string|null $shippingDocument
     * @return $this
     */
    public function setShippingDocument(?string $shippingDocument): self
    {
        $this->shippingDocument = $shippingDocument;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingPhoneCell(): ?string
    {
        return $this->shippingPhoneCell;
    }

    /**
     * @param string|null $shippingPhoneCell
     * @return $this
     */
    public function setShippingPhoneCell(?string $shippingPhoneCell): self
    {
        $this->shippingPhoneCell = $shippingPhoneCell;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingPhoneHome(): ?string
    {
        return $this->shippingPhoneHome;
    }

    /**
     * @param string|null $shippingPhoneHome
     * @return $this
     */
    public function setShippingPhoneHome(?string $shippingPhoneHome): self
    {
        $this->shippingPhoneHome = $shippingPhoneHome;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingEmail(): ?string
    {
        return $this->shippingEmail;
    }

    /**
     * @param string|null $shippingEmail
     * @return $this
     */
    public function setShippingEmail(?string $shippingEmail): self
    {
        $this->shippingEmail = $shippingEmail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCountry(): ?string
    {
        return $this->shippingCountry;
    }

    /**
     * @param string|null $shippingCountry
     * @return Order
     */
    public function setShippingCountry(?string $shippingCountry): self
    {
        $this->shippingCountry = $shippingCountry;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCountryName(): ?string
    {
        return $this->shippingCountryName;
    }

    /**
     * @param string|null $shippingCountryName
     * @return Order
     */
    public function setShippingCountryName(?string $shippingCountryName): self
    {
        $this->shippingCountryName = $shippingCountryName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingState(): ?string
    {
        return $this->shippingState;
    }

    /**
     * @param string|null $shippingState
     * @return Order
     */
    public function setShippingState(?string $shippingState): self
    {
        $this->shippingState = $shippingState;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingStateName(): ?string
    {
        return $this->shippingStateName;
    }

    /**
     * @param string|null $shippingStateName
     * @return Order
     */
    public function setShippingStateName(?string $shippingStateName): self
    {
        $this->shippingStateName = $shippingStateName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCity(): ?string
    {
        return $this->shippingCity;
    }

    /**
     * @param string|null $homeCity
     * @return Order
     */
    public function setShippingCity(?string $homeCity): self
    {
        $this->shippingCity = $homeCity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCityName(): ?string
    {
        return $this->shippingCityName;
    }

    /**
     * @param string|null $homeCityName
     * @return Order
     */
    public function setShippingCityName(?string $homeCityName): self
    {
        $this->shippingCityName = $homeCityName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    /**
     * @param string|null $shippingAddress
     * @return Order
     */
    public function setShippingAddress(?string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingPostalCode(): ?string
    {
        return $this->shippingPostalCode;
    }

    /**
     * @param string|null $shippingPostalCode
     * @return Order
     */
    public function setShippingPostalCode(?string $shippingPostalCode): self
    {
        $this->shippingPostalCode = $shippingPostalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingAddInfo(): ?string
    {
        return $this->shippingAddInfo;
    }

    /**
     * @param string|null $shippingAddInfo
     * @return Order
     */
    public function setShippingAddInfo(?string $shippingAddInfo): self
    {
        $this->shippingAddInfo = $shippingAddInfo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillAddressId(): ?string
    {
        return $this->billAddressId;
    }

    /**
     * @param string|null $billAddressId
     * @return Order
     */
    public function setBillAddressId(?string $billAddressId): self
    {
        $this->billAddressId = $billAddressId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillName(): ?string
    {
        return $this->billName;
    }

    /**
     * @param string|null $billName
     * @return Order
     */
    public function setBillName(?string $billName): self
    {
        $this->billName = $billName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillIdentityNumber(): ?string
    {
        return $this->billIdentityNumber;
    }

    /**
     * @param string|null $billIdentityNumber
     * @return Order
     */
    public function setBillIdentityNumber(?string $billIdentityNumber): self
    {
        $this->billIdentityNumber = $billIdentityNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillIdentityType(): ?string
    {
        return $this->billIdentityType;
    }

    /**
     * @param string|null $billIdentityType
     * @return Order
     */
    public function setBillIdentityType(?string $billIdentityType): self
    {
        $this->billIdentityType = $billIdentityType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillCountry(): ?string
    {
        return $this->billCountry;
    }

    /**
     * @param string|null $billCountry
     * @return Order
     */
    public function setBillCountry(?string $billCountry): self
    {
        $this->billCountry = $billCountry;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillCountryName(): ?string
    {
        return $this->billCountryName;
    }

    /**
     * @param string|null $billCountryName
     * @return Order
     */
    public function setBillCountryName(?string $billCountryName): self
    {
        $this->billCountryName = $billCountryName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillState(): ?string
    {
        return $this->billState;
    }

    /**
     * @param string|null $billState
     * @return Order
     */
    public function setBillState(?string $billState): self
    {
        $this->billState = $billState;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillStateName(): ?string
    {
        return $this->billStateName;
    }

    /**
     * @param string|null $billStateName
     * @return Order
     */
    public function setBillStateName(?string $billStateName): self
    {
        $this->billStateName = $billStateName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillCity(): ?string
    {
        return $this->billCity;
    }

    /**
     * @param string|null $billCity
     * @return Order
     */
    public function setBillCity(?string $billCity): self
    {
        $this->billCity = $billCity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillCityName(): ?string
    {
        return $this->billCityName;
    }

    /**
     * @param string|null $billCityName
     * @return Order
     */
    public function setBillCityName(?string $billCityName): self
    {
        $this->billCityName = $billCityName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillAddress(): ?string
    {
        return $this->billAddress;
    }

    /**
     * @param string|null $billAddress
     * @return Order
     */
    public function setBillAddress(?string $billAddress): self
    {
        $this->billAddress = $billAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillPostalCode(): ?string
    {
        return $this->billPostalCode;
    }

    /**
     * @param string|null $billPostalCode
     * @return Order
     */
    public function setBillPostalCode(?string $billPostalCode): self
    {
        $this->billPostalCode = $billPostalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillAddInfo(): ?string
    {
        return $this->billAddInfo;
    }

    /**
     * @param string|null $billAddInfo
     * @return Order
     */
    public function setBillAddInfo(?string $billAddInfo): self
    {
        $this->billAddInfo = $billAddInfo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubTotalRD(): ?string
    {
        return $this->subTotalRD;
    }

    /**
     * @param string|null $subTotalRD
     * @return Order
     */
    public function setSubTotalRD(?string $subTotalRD): self
    {
        $this->subTotalRD = $subTotalRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubTotalUSD(): ?string
    {
        return $this->subTotalUSD;
    }

    /**
     * @param string|null $subTotalUSD
     * @return Order
     */
    public function setSubTotalUSD(?string $subTotalUSD): self
    {
        $this->subTotalUSD = $subTotalUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductDiscountRD(): ?string
    {
        return $this->productDiscountRD;
    }

    /**
     * @param string|null $productDiscountRD
     * @return Order
     */
    public function setProductDiscountRD(?string $productDiscountRD): self
    {
        $this->productDiscountRD = $productDiscountRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductDiscountUSD(): ?string
    {
        return $this->productDiscountUSD;
    }

    /**
     * @param string|null $productDiscountUSD
     * @return Order
     */
    public function setProductDiscountUSD(?string $productDiscountUSD): self
    {
        $this->productDiscountUSD = $productDiscountUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodePromoDiscount(): ?string
    {
        return $this->codePromoDiscount;
    }

    /**
     * @param string|null $codePromoDiscount
     * @return $this
     */
    public function setCodePromoDiscount(?string $codePromoDiscount): self
    {
        $this->codePromoDiscount = $codePromoDiscount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxRD(): ?string
    {
        return $this->taxRD;
    }

    /**
     * @param string|null $tax
     * @return Order
     */
    public function setTaxRD(?string $taxRD): self
    {
        $this->taxRD = $taxRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxUSD(): ?string
    {
        return $this->taxUSD;
    }

    /**
     * @param string|null $tax
     * @return Order
     */
    public function setTaxUSD(?string $taxUSD): self
    {
        $this->taxUSD = $taxUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInventoryId(): ?string
    {
        return $this->inventoryId;
    }

    /**
     * @param string|null $inventoryId
     * @return $this
     */
    public function setInventoryId(?string $inventoryId): self
    {
        $this->inventoryId = $inventoryId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCost(): ?string
    {
        return $this->shippingCost;
    }

    /**
     * @param string|null $shippingCost
     * @return $this
     */
    public function setShippingCost(?string $shippingCost): self
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippinDiscount(): ?string
    {
        return $this->shippinDiscount;
    }

    /**
     * @param string|null $shippinDiscount
     * @return Order
     */
    public function setShippinDiscount(?string $shippinDiscount): self
    {
        $this->shippinDiscount = $shippinDiscount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotalOrderRD(): ?string
    {
        return $this->totalOrderRD;
    }

    /**
     * @param string|null $totalOrderRD
     * @return Order
     */
    public function setTotalOrderRD(?string $totalOrderRD): self
    {
        $this->totalOrderRD = $totalOrderRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotalOrderUSD(): ?string
    {
        return $this->totalOrderUSD;
    }

    /**
     * @param string|null $totalOrderUSD
     * @return Order
     */
    public function setTotalOrderUSD(?string $totalOrderUSD): self
    {
        $this->totalOrderUSD = $totalOrderUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderDC(): ?string
    {
        return $this->orderDC;
    }

    /**
     * @param string|null $orderDC
     * @return $this
     */
    public function setOrderDC(?string $orderDC): self
    {
        $this->orderDC = $orderDC;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderDU(): ?string
    {
        return $this->orderDU;
    }

    /**
     * @param string|null $orderDU
     * @return $this
     */
    public function setOrderDU(?string $orderDU): self
    {
        $this->orderDU = $orderDU;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTimeInterface|null $dateCreated
     * @return Order
     */
    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTimeInterface|null $dateUpdated
     * @return Order
     */
    public function setDateUpdated(?\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPaymentFiles(): ?array
    {
        return $this->paymentFiles;
    }

    /**
     * @param array|null $paymentFiles
     * @return $this
     */
    public function setPaymentFiles(?array $paymentFiles): self
    {
        $this->paymentFiles = $paymentFiles;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPaymentsReceivedFile(): ?array
    {
        return $this->paymentsReceivedFile;
    }

    /**
     * @param array|null $paymentsReceivedFile
     * @return $this
     */
    public function setPaymentsReceivedFile(?array $paymentsReceivedFile): self
    {
        $this->paymentsReceivedFile = $paymentsReceivedFile;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getDebitCreditNotesFile(): ?array
    {
        return $this->debitCreditNotesFile;
    }

    /**
     * @param array|null $debitCreditNotesFile
     * @return $this
     */
    public function setDebitCreditNotesFile(?array $debitCreditNotesFile): self
    {
        $this->debitCreditNotesFile = $debitCreditNotesFile;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPaymentsTransactionCodes(): ?array
    {
        return $this->paymentsTransactionCodes;
    }

    /**
     * @param array|null $paymentsTransactionCodes
     * @return $this
     */
    public function setPaymentsTransactionCodes(?array $paymentsTransactionCodes): self
    {
        $this->paymentsTransactionCodes = $paymentsTransactionCodes;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDataJson(): ?string
    {
        return json_encode($this->dataJson);
    }

    /**
     * @param array|null $dataJson
     * @return Order
     */
    public function setDataJson(?array $dataJson): self
    {
        $this->dataJson = $dataJson;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDataUpdateJson(): ?string
    {
        return json_encode($this->dataUpdateJson);
    }

    /**
     * @param array|null $dataUpdateJson
     * @return Order
     */
    public function setDataUpdateJson(?array $dataUpdateJson): self
    {
        $this->dataUpdateJson = $dataUpdateJson;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return Collection<int, Package>
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    /**
     * @param Package $package
     * @return $this
     */
    public function addPackage(Package $package): self
    {
        if (!$this->packages->contains($package)) {
            $this->packages->add($package);
        }

        return $this;
    }

    /**
     * @param Package $package
     * @return $this
     */
    public function removePackage(Package $package): self
    {
        $this->packages->removeElement($package);

        return $this;
    }

    /**
     * @return Collection<int, OrderHistory>
     */
    public function getOrderHistories(): Collection
    {
        return $this->orderHistories;
    }

    /**
     * @param OrderHistory $orderHistory
     * @return $this
     */
    public function addOrderHistory(OrderHistory $orderHistory): self
    {
        if (!$this->orderHistories->contains($orderHistory)) {
            $this->orderHistories->add($orderHistory);
        }

        return $this;
    }

    public function removeOrderHistory(OrderHistory $orderHistory): self
    {
        $this->orderHistories->removeElement($orderHistory);

        return $this;
    }

    public function __toString(): string
    {
        return 'ODN: ' . $this->orderId . ' - CLI: ' . $this->customer->getName();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        [$itemsRD, $itemsUSD, $packages] = [[], [], []];


        $paymentsFilesUrl = [];
        $paymentsFiles = $this->invoice ? ($this->invoice->getPayments() ?: null) : null;

        if ($paymentsFiles) {
            foreach ($paymentsFiles as $paymentFile) {
                $paymentsFilesUrl[] = $paymentFile->getVoucherFile();
            }
        }

        /** @var Product $product */
        foreach ($this->products as $product) {
            if ($product->getCurrency()->getId() == 1) { //si es moneda RD
                $itemsRD[] = $product->toArray();
            } else { //SI ES DOLAR
                $itemsUSD[] = $product->toArray();
            }
        }

        /** @var Package $package */
        foreach ($this->packages as $package) {
            $packages[] = $package->toArray();
        }

        return [
            'order_id' => $this->orderId,
            'sales_id' => $this->inventoryId,
            'created_at' => $this->orderDC,
            'status_order' => $this->getOriginalStatusOrder($this->statusOrder),
            'packages' => $packages,
            'warehouse_id' => $this->wareHouseId,
            'itemsRD' => $itemsRD,
            'itemsUSD' => $itemsUSD,
            'customer' => $this->customer->toArray() ?? [],
            'international_shipping' => $this->shippingInternational,
            'shipping' => $this->shipping,
            'bill_file' => NULL,
            'proforma_bill_file' => $this->billFile,
            'payments_files' => $paymentsFilesUrl,
            'payments_received_files' => $this->paymentsReceivedFile,
            'payments_transactions_codes' => $this->paymentsTransactionCodes,
            'debit_credit_notes_files' => $this->debitCreditNotesFile,
            'receiver' => [
                'name' => $this->shippingName,
                'document_type' => $this->shippingDocumentType,
                'document' => $this->shippingDocument,
                'phone_cell' => $this->shippingPhoneCell,
                'phone_home' => $this->shippingPhoneHome,
                'email' => $this->shippingEmail,
                'country_id' => $this->shippingCountry,
                'state_id' => $this->shippingState,
                'city_id' => $this->shippingCity,
                'address' => $this->shippingAddress,
                'cod_zip' => $this->shippingPostalCode,
                'additional_info' => $this->shippingAddInfo,
            ],
            'bill_address' => [
                'bill_address_id' => $this->billAddressId,
                'country_id' => $this->billCountry,
                'state_id' => $this->billState,
                'city_id' => $this->billCity,
                'address' => $this->billAddress,
                'cod_zip' => $this->billPostalCode,
            ],
            'subtotal_rd' => $this->subTotalRD,
            'total_product_discount_rd' => $this->productDiscountRD,
            'tax_rd' => $this->taxRD,
            'total_order_rd' => $this->totalOrderRD,

            'subtotal_usd' => $this->subTotalUSD,
            'total_product_discount_usd' => $this->productDiscountUSD,
            'tax_usd' => $this->taxUSD,
            'total_order_usd' => $this->totalOrderUSD,

            'promotional_code_discount' => $this->codePromoDiscount,
            'shipping_cost' => $this->shippingCost,
            'shipping_discount' => $this->shippinDiscount,
        ];
    }

    public function getOriginalStatusOrder(?string $statusOrder): int
    {
        return match (strtolower($statusOrder)) {
            strtolower('Open') => 1,
            strtolower('Partially Shipped') => 2,
            strtolower('Shipped') => 3,
            strtolower('Picked') => 4,
            strtolower('Packed') => 5,
            strtolower('Confirmed') => 6,
            strtolower('Canceled') => 7,
            default => 0,
        };
    }

    /**
     * @return array
     */
    public function toInventoryArray(): array
    {
        $items = [];

        /** @var Product $product */
        foreach ($this->products as $product) {
            $items[] = [
                'product_id' => $product->getProductId(),
                'product_id_crm' => $product->getProductId(),
                'qty' => $product->getQuantity(),
            ];
        }

        return [
            'warehouse_id' => $this?->wareHouseId,
            'receiver' => [
                'document' => $this?->shippingDocument,
                'name' => $this?->shippingName,
                'last_name' => $this?->customer?->getLastName(),
                'email' => $this?->shippingEmail,
                'phone_home' => $this?->shippingPhoneHome,
                'phone_cell' => $this?->shippingPhoneCell,
                'destiny' => [
                    'country_id' => $this?->shippingCountry,
                    'state_id' => $this?->shippingState,
                    'city_id' => $this?->shippingCity,
                    'address' => $this?->shippingAddress,
                    'cod_zip' => $this?->shippingPostalCode,
                    'shipping_type' => 4
                ],
            ],
            'items' => $items,
        ];
    }

    public function getPaymentType(): ?PaymentType
    {
        return $this->payment_type;
    }

    public function setPaymentType(?PaymentType $payment_type): self
    {
        $this->payment_type = $payment_type;

        return $this;
    }

    public function getCardnetSession(): ?string
    {
        return $this->cardnet_session;
    }

    public function setCardnetSession(?string $cardnet_session): self
    {
        $this->cardnet_session = $cardnet_session;

        return $this;
    }

    public function getCardnetSessionKey(): ?string
    {
        return $this->cardnet_session_key;
    }

    public function setCardnetSessionKey(?string $cardnet_session_key): self
    {
        $this->cardnet_session_key = $cardnet_session_key;

        return $this;
    }

    public function getCardnetAuthorizationCode(): ?string
    {
        return $this->cardnet_authorization_code;
    }

    public function setCardnetAuthorizationCode(?string $cardnet_authorization_code): self
    {
        $this->cardnet_authorization_code = $cardnet_authorization_code;

        return $this;
    }

    public function getCardnetTxToken(): ?string
    {
        return $this->cardnet_tx_token;
    }

    public function setCardnetTxToken(?string $cardnet_tx_token): self
    {
        $this->cardnet_tx_token = $cardnet_tx_token;

        return $this;
    }

    public function getCardnetResponseCode(): ?string
    {
        return $this->cardnet_response_code;
    }

    public function setCardnetResponseCode(?string $cardnet_response_code): self
    {
        $this->cardnet_response_code = $cardnet_response_code;

        return $this;
    }

    public function getCardnetCreditcardNumber(): ?string
    {
        return $this->cardnet_creditcard_number;
    }

    public function setCardnetCreditcardNumber(?string $cardnet_creditcard_number): self
    {
        $this->cardnet_creditcard_number = $cardnet_creditcard_number;

        return $this;
    }

    public function getCardnetRetrivalReferenceNumber(): ?string
    {
        return $this->cardnet_retrival_reference_number;
    }

    public function setCardnetRetrivalReferenceNumber(?string $cardnet_retrival_reference_number): self
    {
        $this->cardnet_retrival_reference_number = $cardnet_retrival_reference_number;

        return $this;
    }

    public function getCardnetRemoteResponseCode(): ?string
    {
        return $this->cardnet_remote_response_code;
    }

    public function setCardnetRemoteResponseCode(?string $cardnet_remote_response_code): self
    {
        $this->cardnet_remote_response_code = $cardnet_remote_response_code;

        return $this;
    }

    public function isFiscalInvoiceRequired(): ?bool
    {
        return $this->fiscal_invoice_required;
    }

    public function setFiscalInvoiceRequired(?bool $fiscal_invoice_required): self
    {
        $this->fiscal_invoice_required = $fiscal_invoice_required;

        return $this;
    }
}
