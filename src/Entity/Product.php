<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: '`tb_order_product`')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Order', cascade: ['persist'], inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Order $order = null;

    #[ORM\Column(name: 'product_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $productId = null;

    #[ORM\Column(name: 'product_id_3pl', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $productId3Pl = null;

    #[ORM\Column(name: 'warehouse_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $wareHouseId = null;

    #[ORM\Column(name: 'warehouse', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $wareHouse = null;

    #[ORM\Column(name: 'category_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $categoryId = null;

    #[ORM\Column(name: 'category', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $category = null;

    #[ORM\Column(name: 'sub_category_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $subCategoryId = null;

    #[ORM\Column(name: 'sub_category', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $subCategory = null;

    #[ORM\Column(name: 'brand_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $brandId = null;

    #[ORM\Column(name: 'brand', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $brand = null;

    #[ORM\Column(name: 'sku', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $sku = null;

    #[ORM\Column(name: 'code', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $code = null;

    #[ORM\Column(name: 'part_number', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $partNumber = null;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\Column(name: 'description', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $description = null;

    #[ORM\Column(name: 'weight', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $weight = null;

    #[ORM\Column(name: 'condition_id', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $conditionId = null;

    #[ORM\Column(name: 'in_condition', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $condition = null;

    #[ORM\Column(name: 'cost', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $cost = null;

    #[ORM\Column(name: 'discount', type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $discount;

    #[ORM\Column(name: 'quantity', type: Types::INTEGER, nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(name: 'is_onhand', type: Types::STRING, length: 20, nullable: true)]
    #[Assert\Length(max: 20)]
    private ?string $onhand = null;

    #[ORM\Column(name: 'is_commited', type: Types::STRING, length: 20, nullable: true)]
    #[Assert\Length(max: 20)]
    private ?string $commited = null;

    #[ORM\Column(name: 'is_incomming', type: Types::STRING, length: 20, nullable: true)]
    #[Assert\Length(max: 20)]
    private ?string $incomming = null;

    #[ORM\Column(name: 'is_available', type: Types::STRING, length: 20, nullable: true)]
    #[Assert\Length(max: 20)]
    private ?string $available = null;

    #[ORM\Column(name: 'product_dc', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $productDC = null;

    #[ORM\Column(name: 'product_du', type: Types::STRING, length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $productDU = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'date_updated', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdated;

    #[ORM\Column(name: 'data_json', type: Types::JSON, nullable: true)]
    private ?array $dataJson = [];

    #[ORM\Column(name: 'data_update_json', type: Types::JSON, nullable: true)]
    private ?array $dataUpdateJson = [];

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'currency_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Currency $currency = null;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
        $this->discount = 0.00;
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order|null $order
     * @return Product
     */
    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        $order?->addProduct($this);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * @param string|null $productId
     * @return Product
     */
    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductId3Pl(): ?string
    {
        return $this->productId3Pl;
    }

    /**
     * @param string|null $productId3Pl
     * @return $this
     */
    public function setProductId3Pl(?string $productId3Pl): self
    {
        $this->productId3Pl = $productId3Pl;

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
     * @return Product
     */
    public function setWareHouseId(?string $wareHouseId): self
    {
        $this->wareHouseId = $wareHouseId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWareHouse(): ?string
    {
        return $this->wareHouse;
    }

    /**
     * @param string|null $wareHouse
     * @return Product
     */
    public function setWareHouse(?string $wareHouse): self
    {
        $this->wareHouse = $wareHouse;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    /**
     * @param string|null $categoryId
     * @return Product
     */
    public function setCategoryId(?string $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Product
     */
    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubCategoryId(): ?string
    {
        return $this->subCategoryId;
    }

    /**
     * @param string|null $subCategoryId
     * @return Product
     */
    public function setSubCategoryId(?string $subCategoryId): self
    {
        $this->subCategoryId = $subCategoryId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubCategory(): ?string
    {
        return $this->subCategory;
    }

    /**
     * @param string|null $subCategory
     * @return Product
     */
    public function setSubCategory(?string $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrandId(): ?string
    {
        return $this->brandId;
    }

    /**
     * @param string|null $brandId
     * @return Product
     */
    public function setBrandId(?string $brandId): self
    {
        $this->brandId = $brandId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return Product
     */
    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     * @return Product
     */
    public function setSku(?string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return Product
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }

    /**
     * @param string|null $partNumber
     * @return Product
     */
    public function setPartNumber(?string $partNumber): self
    {
        $this->partNumber = $partNumber;

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
     * @return Product
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Product
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     * @return Product
     */
    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getConditionId(): ?string
    {
        return $this->conditionId;
    }

    /**
     * @param string|null $conditionId
     * @return Product
     */
    public function setConditionId(?string $conditionId): self
    {
        $this->conditionId = $conditionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCondition(): ?string
    {
        return $this->condition;
    }

    /**
     * @param string|null $condition
     * @return Product
     */
    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCost(): ?string
    {
        return $this->cost;
    }

    /**
     * @param string|null $cost
     * @return Product
     */
    public function setCost(?string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    /**
     * @param string|null $discount
     * @return $this
     */
    public function setDiscount(?string $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return $this
     */
    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOnhand(): ?string
    {
        return $this->onhand;
    }

    /**
     * @param string|null $onhand
     * @return Product
     */
    public function setOnhand(?string $onhand): self
    {
        $this->onhand = $onhand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommited(): ?string
    {
        return $this->commited;
    }

    /**
     * @param string|null $commited
     * @return Product
     */
    public function setCommited(?string $commited): self
    {
        $this->commited = $commited;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIncomming(): ?string
    {
        return $this->incomming;
    }

    /**
     * @param string|null $incomming
     * @return Product
     */
    public function setIncomming(?string $incomming): self
    {
        $this->incomming = $incomming;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvailable(): ?string
    {
        return $this->available;
    }

    /**
     * @param string|null $available
     * @return Product
     */
    public function setAvailable(?string $available): self
    {
        $this->available = $available;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductDC(): ?string
    {
        return $this->productDC;
    }

    /**
     * @param string|null $productDC
     * @return Product
     */
    public function setProductDC(?string $productDC): self
    {
        $this->productDC = $productDC;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductDU(): ?string
    {
        return $this->productDU;
    }

    /**
     * @param string|null $productDU
     * @return Product
     */
    public function setProductDU(?string $productDU): self
    {
        $this->productDU = $productDU;

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
     * @return Product
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
     * @return Product
     */
    public function setDateUpdated(?\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getDataJson(): ?array
    {
        return $this->dataJson;
    }

    /**
     * @param array|null $dataJson
     * @return Product
     */
    public function setDataJson(?array $dataJson): self
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
     * @return Product
     */
    public function setDataUpdateJson(?array $dataUpdateJson): self
    {
        $this->dataUpdateJson = $dataUpdateJson;

        return $this;
    }

    public function __toString(): string
    {
        return 'Pd-'.$this->name.'-'.$this->id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->name,
            'qty' => $this->quantity,
            'weight' => $this->weight,
            'price' => $this->cost,
            'discount' => $this->discount,
            'currency_id'=>$this->currency->getId(),
            'currency_sign'=>$this->currency->getSign()
        ];
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

}
