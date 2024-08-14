<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: '`tb_customer`')]
#[UniqueEntity('apiId')]
#[UniqueEntity('email')]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(name: 'api_id', type: Types::STRING, unique: true)]
    #[Assert\NotNull]
    private ?string $apiId = null;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 100, unique: true, nullable: true)]
    #[Assert\Length(max: 100)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\Column(name: 'last_name', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $lastName = null;

    #[ORM\Column(name: 'phone_code', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $phoneCode = null;

    #[ORM\Column(name: 'phone', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $phone = null;

    #[ORM\Column(name: 'cell_phone', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $cellPhone = null;

    #[ORM\Column(name: 'customer_type', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $customerType;

    #[ORM\Column(name: 'customer_type_role', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $customerTypeRole = null;

    #[ORM\Column(name: 'identity_type', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $identityType = null;

    #[ORM\Column(name: 'identity_number', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $identityNumber = null;

    #[ORM\Column(name: 'status', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $status;

    #[ORM\Column(name: 'gender', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $gender;

    #[ORM\Column(name: 'birthday', type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDay;

    #[ORM\Column(name: 'home_address_id', type: Types::STRING, nullable: true)]
    private ?string $homeAddressId = null;

    #[ORM\Column(name: 'home_country', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $homeCountry = null;

    #[ORM\Column(name: 'home_state', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $homeState = null;

    #[ORM\Column(name: 'home_city', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $homeCity = null;

    #[ORM\Column(name: 'home_address', type: Types::TEXT, nullable: true)]
    private ?string $homeAddress = null;

    #[ORM\Column(name: 'home_postal_code', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $homePostalCode = null;

    #[ORM\Column(name: 'home_add_info', type: Types::TEXT, nullable: true)]
    private ?string $homeAddInfo = null;

    #[ORM\Column(name: 'bill_address_id', type: Types::STRING, nullable: true)]
    private ?string $billAddressId = null;

    #[ORM\Column(name: 'bill_name', type: Types::STRING, nullable: true)]
    private ?string $billName = null;

    #[ORM\Column(name: 'bill_country', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $billCountry = null;

    #[ORM\Column(name: 'bill_state', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $billState = null;

    #[ORM\Column(name: 'bill_city', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $billCity = null;

    #[ORM\Column(name: 'bill_address', type: Types::TEXT, nullable: true)]
    private ?string $billAddress = null;

    #[ORM\Column(name: 'bill_postal_code', type: Types::STRING, length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $billPostalCode = null;

    #[ORM\Column(name: 'bill_add_info', type: Types::TEXT, nullable: true)]
    private ?string $billAddInfo = null;

    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'date_updated', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdated;

    #[ORM\Column(name: 'data_json', type: Types::JSON, nullable: true)]
    private ?array $dataJson = [];

    #[ORM\Column(name: 'data_update_json', type: Types::JSON, nullable: true)]
    private ?array $dataUpdateJson = [];

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class, orphanRemoval: true)]
    private Collection $orders;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();

        $this->orders = new ArrayCollection();

        $this->customerType = 'Empresa';
        $this->gender = 'Masculino';
        $this->status = 1;

        $this->birthDay = new \DateTime('2000-01-01');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCustomer($this);
        }

        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDataJson(): array
    {
        return $this->dataJson;
    }

    /**
     * @param array|null $dataJson
     * @return $this
     */
    public function setDataJson(?array $dataJson): Customer
    {
        $this->dataJson = $dataJson;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getDataUpdateJson(): ?array
    {
        return $this->dataUpdateJson;
    }

    /**
     * @param array|null $dataUpdateJson
     * @return $this
     */
    public function setDataUpdateJson(?array $dataUpdateJson): Customer
    {
        $this->dataUpdateJson = $dataUpdateJson;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiId(): ?string
    {
        return $this->apiId;
    }

    /**
     * @param string|null $apiId
     * @return $this
     */
    public function setApiId(?string $apiId): Customer
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): Customer
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): Customer
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return $this
     */
    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return $this
     */
    public function setPhone(?string $phone): Customer
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCellPhone(): ?string
    {
        return $this->cellPhone;
    }

    /**
     * @param string|null $cellPhone
     * @return $this
     */
    public function setCellPhone(?string $cellPhone): Customer
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerType(): ?string
    {
        return $this->customerType;
    }

    /**
     * @param string|null $customerType
     * @return $this
     */
    public function setCustomerType(?string $customerType): Customer
    {
        $this->customerType = $customerType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return $this
     */
    public function setStatus(?string $status): Customer
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     * @return $this
     */
    public function setGender(?string $gender): Customer
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(?\DateTimeInterface $birthDay): Customer
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    public function getHomeAddressId(): ?string
    {
        return $this->homeAddressId;
    }

    public function setHomeAddressId(?string $homeAddressId): Customer
    {
        $this->homeAddressId = $homeAddressId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeCountry(): ?string
    {
        return $this->homeCountry;
    }

    /**
     * @param string|null $homeCountry
     * @return $this
     */
    public function setHomeCountry(?string $homeCountry): Customer
    {
        $this->homeCountry = $homeCountry;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeState(): ?string
    {
        return $this->homeState;
    }

    /**
     * @param string|null $homeState
     * @return $this
     */
    public function setHomeState(?string $homeState): Customer
    {
        $this->homeState = $homeState;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeCity(): ?string
    {
        return $this->homeCity;
    }

    /**
     * @param string|null $homeCity
     * @return $this
     */
    public function setHomeCity(?string $homeCity): Customer
    {
        $this->homeCity = $homeCity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddress(): ?string
    {
        return $this->homeAddress;
    }

    /**
     * @param string|null $homeAddress
     * @return $this
     */
    public function setHomeAddress(?string $homeAddress): Customer
    {
        $this->homeAddress = $homeAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomePostalCode(): ?string
    {
        return $this->homePostalCode;
    }

    /**
     * @param string|null $homePostalCode
     * @return $this
     */
    public function setHomePostalCode(?string $homePostalCode): Customer
    {
        $this->homePostalCode = $homePostalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddInfo(): ?string
    {
        return $this->homeAddInfo;
    }

    /**
     * @param string|null $homeAddInfo
     * @return $this
     */
    public function setHomeAddInfo(?string $homeAddInfo): Customer
    {
        $this->homeAddInfo = $homeAddInfo;

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
     * @return $this
     */
    public function setBillAddressId(?string $billAddressId): Customer
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
     * @return $this
     */
    public function setBillName(?string $billName): Customer
    {
        $this->billName = $billName;

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
     * @return $this
     */
    public function setBillCountry(?string $billCountry): Customer
    {
        $this->billCountry = $billCountry;

        return $this;
    }

    public function getBillState(): ?string
    {
        return $this->billState;
    }

    /**
     * @param string|null $billState
     * @return $this
     */
    public function setBillState(?string $billState): Customer
    {
        $this->billState = $billState;

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
     * @return $this
     */
    public function setBillCity(?string $billCity): Customer
    {
        $this->billCity = $billCity;

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
     * @return $this
     */
    public function setBillAddress(?string $billAddress): Customer
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
     * @return $this
     */
    public function setBillPostalCode(?string $billPostalCode): Customer
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
     * @return $this
     */
    public function setBillAddInfo(?string $billAddInfo): Customer
    {
        $this->billAddInfo = $billAddInfo;

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
     * @return $this
     */
    public function setDateCreated(?\DateTimeInterface $dateCreated): Customer
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
     * @return $this
     */
    public function setDateUpdated(?\DateTimeInterface $dateUpdated): Customer
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneCode(): ?string
    {
        return $this->phoneCode;
    }

    /**
     * @param string|null $phoneCode
     * @return $this
     */
    public function setPhoneCode(?string $phoneCode): self
    {
        $this->phoneCode = $phoneCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerTypeRole(): ?string
    {
        return $this->customerTypeRole;
    }

    /**
     * @param string|null $customerTypeRole
     * @return $this
     */
    public function setCustomerTypeRole(?string $customerTypeRole): self
    {
        $this->customerTypeRole = $customerTypeRole;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdentityType(): ?string
    {
        return $this->identityType;
    }

    /**
     * @param string|null $identityType
     * @return $this
     */
    public function setIdentityType(?string $identityType): self
    {
        $this->identityType = $identityType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdentityNumber(): ?string
    {
        return $this->identityNumber;
    }

    /**
     * @param string|null $identityNumber
     * @return $this
     */
    public function setIdentityNumber(?string $identityNumber): self
    {
        $this->identityNumber = $identityNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name.' '.$this->lastName;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'customer_type' => $this->customerType,
            'name' => $this->name.' '.$this->lastName,
            'email' => $this->email,
            'phone_code' => $this->phoneCode,
            'cel_phone_customer' => $this->cellPhone,
            'phone_customer' => $this->phone,
            'customer_identity_type' => $this->identityType,
            'customer_identity_number' => $this->identityNumber,
        ];
    }
}
