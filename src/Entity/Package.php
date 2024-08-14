<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
#[ORM\Table(name: '`tb_order_package`')]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Order', cascade: ['persist'], inversedBy: 'packages')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Order $order = null;

    #[ORM\Column(name: 'lb', length: 10, nullable: true)]
    private ?string $lb = null;

    #[ORM\Column(name: 'height', length: 10, nullable: true)]
    private ?string $height = null;

    #[ORM\Column(name: 'width', length: 10, nullable: true)]
    private ?string $width = null;

    #[ORM\Column(name: 'depth', length: 10, nullable: true)]
    private ?string $depth = null;

    #[ORM\Column(name: 'courier', length: 10, nullable: true)]
    private ?string $courierId = null;

    #[ORM\Column(name: 'courier_name', length: 100, nullable: true)]
    private ?string $courierName = null;

    #[ORM\Column(name: 'service_id', length: 10, nullable: true)]
    private ?string $serviceId = null;

    #[ORM\Column(name: 'service_name', length: 100, nullable: true)]
    private ?string $serviceName = null;

    #[ORM\Column(name: 'guide_number', length: 100, nullable: true)]
    private ?string $guideNumber = null;

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

        $order?->addPackage($this);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLb(): ?string
    {
        return $this->lb;
    }

    /**
     * @param string|null $lb
     * @return $this
     */
    public function setLb(?string $lb): self
    {
        $this->lb = $lb;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeight(): ?string
    {
        return $this->height;
    }

    /**
     * @param string|null $height
     * @return $this
     */
    public function setHeight(?string $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * @param string|null $width
     * @return $this
     */
    public function setWidth(?string $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepth(): ?string
    {
        return $this->depth;
    }

    /**
     * @param string|null $depth
     * @return $this
     */
    public function setDepth(?string $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCourierId(): ?string
    {
        return $this->courierId;
    }

    /**
     * @param string|null $courierId
     * @return $this
     */
    public function setCourierId(?string $courierId): self
    {
        $this->courierId = $courierId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCourierName(): ?string
    {
        return $this->courierName;
    }

    /**
     * @param string|null $courierName
     * @return $this
     */
    public function setCourierName(?string $courierName): self
    {
        $this->courierName = $courierName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }

    /**
     * @param string|null $serviceId
     * @return $this
     */
    public function setServiceId(?string $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    /**
     * @param string|null $serviceName
     * @return $this
     */
    public function setServiceName(?string $serviceName): self
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuideNumber(): ?string
    {
        return $this->guideNumber;
    }

    /**
     * @param string|null $guideNumber
     * @return $this
     */
    public function setGuideNumber(?string $guideNumber): self
    {
        $this->guideNumber = $guideNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'Pkg'.$this->id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "lb" => $this->lb,
            "height" => $this->height,
            "width" => $this->width,
            "depth" => $this->depth,
            "courier_id" => $this->courierId,
            "courier_name" => $this->courierName,
            "service_id" => $this->serviceId,
            "service_name" => $this->serviceName,
            "guide_number" => $this->guideNumber,
        ];
    }
}
