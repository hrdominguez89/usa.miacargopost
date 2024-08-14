<?php

namespace App\Entity;

use App\Repository\OrderHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderHistoryRepository::class)]
#[ORM\Table(name: '`tb_order_history`')]
class OrderHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Order', cascade: ['persist'], inversedBy: 'orderHistories')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: true)]
    private ?Order $order = null;

    #[ORM\Column(name: 'data_json', type: Types::JSON)]
    private ?array $dataJson = [];

    #[ORM\Column(name: 'action_name', type: Types::STRING, length: 50)]
    private ?string $actionName = null;

    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
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
     * @return $this
     */
    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        $order?->addOrderHistory($this);

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
     * @return $this
     */
    public function setDataJson(?array $dataJson): self
    {
        $this->dataJson = $dataJson;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionName(): ?string
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     * @return $this
     */
    public function setActionName(string $actionName): self
    {
        $this->actionName = $actionName;

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
     * @param \DateTimeInterface $dateCreated
     * @return $this
     */
    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
