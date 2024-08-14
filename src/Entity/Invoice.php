<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[ORM\Table(name: '`tb_invoice`')]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'invoice', targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    private ?Order $order;

    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'employee_name', type: Types::STRING, length: 100)]
    #[Assert\Length(max: 100)]
    #[Assert\NotBlank]
    private ?string $employeeName = null;

    #[ORM\Column(name: 'status_invoice', type: Types::STRING, length: 100)]
    #[Assert\Length(max: 100)]
    #[Assert\NotBlank]
    private ?string $statusInvoice = null;

    #[ORM\Column(name: 'payment_deadline_invoice', type: Types::STRING, length: 100)]
    #[Assert\Length(max: 100)]
    #[Assert\NotBlank]
    private ?string $paymentDeadlineInvoice;

    #[ORM\Column(name: 'total_rd', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $totalRD;

    #[ORM\Column(name: 'deuda_rd', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $deudaRD;

    #[ORM\Column(name: 'partial_rd', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $partialRD;

    #[ORM\Column(name: 'total_usd', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $totalUSD;

    #[ORM\Column(name: 'deuda_usd', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $deudaUSD;

    #[ORM\Column(name: 'partial_usd', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $partialUSD;

    #[ORM\Column(name: 'flete', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $flete;

    #[ORM\Column(name: 'fuel', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $fuel;

    #[ORM\Column(name: 'sure', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $sure;

    #[ORM\Column(name: 'other_service', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $otherService;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: Payment::class, orphanRemoval: true)]
    private Collection $payments;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fiscalInvoiceNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invoiceFile = null;

    public function __construct(?Order $order)
    {
        $this->order = $order;

        $this->dateCreated = new \DateTime();

        $this->totalRD = 0.00;
        $this->partialRD = 0.00;
        $this->deudaRD = 0.00;

        $this->totalUSD = 0.00;
        $this->partialUSD = 0.00;
        $this->deudaUSD = 0.00;

        $this->flete = 0.00;
        $this->fuel = 0.00;
        $this->sure = 0.00;
        $this->otherService = 0.00;

        $this->paymentDeadlineInvoice = '24h';
        $this->payments = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated?->format('Y-m-d H:i:s');
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

    /**
     * @return string|null
     */
    public function getEmployeeName(): ?string
    {
        return $this->employeeName;
    }

    /**
     * @param string $employeeName
     * @return $this
     */
    public function setEmployeeName(string $employeeName): self
    {
        $this->employeeName = $employeeName;

        return $this;
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

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusInvoice(): ?string
    {
        return $this->statusInvoice;
    }

    /**
     * @param string $statusInvoice
     * @return $this
     */
    public function setStatusInvoice(string $statusInvoice): self
    {
        $this->statusInvoice = $statusInvoice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentDeadlineInvoice(): ?string
    {
        return $this->paymentDeadlineInvoice;
    }

    /**
     * @param string $paymentDeadlineInvoice
     * @return $this
     */
    public function setPaymentDeadlineInvoice(string $paymentDeadlineInvoice): self
    {
        $this->paymentDeadlineInvoice = $paymentDeadlineInvoice;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setInvoice($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getInvoice() === $this) {
                $payment->setInvoice(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotalRD(): ?string
    {
        return $this->totalRD;
    }

    /**
     * @param string|null $totalRD
     * @return $this
     */
    public function setTotalRD(?string $totalRD): self
    {
        $this->totalRD = $totalRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeudaRD(): ?string
    {
        return $this->deudaRD;
    }

    /**
     * @param string|null $deudaRD
     * @return $this
     */
    public function setDeudaRD(?string $deudaRD): self
    {
        $this->deudaRD = $deudaRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartialRD(): ?string
    {
        return $this->partialRD;
    }

    /**
     * @param string|null $partialRD
     * @return $this
     */
    public function setPartialRD(?string $partialRD): self
    {
        $this->partialRD = $partialRD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotalUSD(): ?string
    {
        return $this->totalUSD;
    }

    /**
     * @param string|null $totalUSD
     * @return $this
     */
    public function setTotalUSD(?string $totalUSD): self
    {
        $this->totalUSD = $totalUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeudaUSD(): ?string
    {
        return $this->deudaUSD;
    }

    /**
     * @param string|null $deudaUSD
     * @return $this
     */
    public function setDeudaUSD(?string $deudaUSD): self
    {
        $this->deudaUSD = $deudaUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartialUSD(): ?string
    {
        return $this->partialUSD;
    }

    /**
     * @param string|null $partialUSD
     * @return $this
     */
    public function setPartialUSD(?string $partialUSD): self
    {
        $this->partialUSD = $partialUSD;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFlete(): ?string
    {
        return $this->flete;
    }

    /**
     * @param string|null $flete
     * @return $this
     */
    public function setFlete(?string $flete): self
    {
        $this->flete = $flete;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    /**
     * @param string|null $fuel
     * @return $this
     */
    public function setFuel(?string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSure(): ?string
    {
        return $this->sure;
    }

    /**
     * @param string|null $sure
     * @return $this
     */
    public function setSure(?string $sure): self
    {
        $this->sure = $sure;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherService(): ?string
    {
        return $this->otherService;
    }

    /**
     * @param string|null $otherService
     * @return $this
     */
    public function setOtherService(?string $otherService): self
    {
        $this->otherService = $otherService;

        return $this;
    }


    /**
     * @return $this
     */
    public function calculateAmount(): self
    {
        $this->partialRD = 0.00;
        $this->partialUSD = 0.00;

        foreach ($this->order->getProducts() as $product) {
            if ($product->getCurrency()->getId() == 1) { //si es peso dominicano
                $this->partialRD += ($product->getQuantity() * ($product->getCost() - ($product->getCost() / 100) * $product->getDiscount()));
                $this->totalRD = (($this->partialRD) + ($this->fuel + $this->flete + $this->sure + $this->otherService)) - ($this->order->getShippinDiscount() + $this->order->getCodePromoDiscount());

                if (@$this->order->getPaymentType() && ($this->order->getPaymentType()->getId() == 2 || $this->order->getPaymentType()->getId() == 3)) {
                    $this->deudaRD = 0;  //si el tipo de pago fue realizando con cardnet la deuda es 0
                } else {
                    $this->deudaRD = $this->totalRD;
                    foreach ($this->payments as $payment) {
                        $this->deudaRD -= $payment->getCurrency()->getId() == 1 ? $payment->getAmount() : 0;
                    }
                }

            } else {//CALCULO EN DOLARES
                $this->partialUSD += ($product->getQuantity() * ($product->getCost() - ($product->getCost() / 100) * $product->getDiscount()));
                $this->totalUSD = (($this->partialUSD) + ($this->fuel + $this->flete + $this->sure + $this->otherService)) - ($this->order->getShippinDiscount() + $this->order->getCodePromoDiscount());

                // if (@$this->order->getPaymentType() && ($this->order->getPaymentType()->getId() == 2 || $this->order->getPaymentType()->getId() == 3)) {
                $this->deudaUSD = 0;  //si el tipo de pago fue realizando con cardnet la deuda es 0
                // } else {

                $this->deudaUSD = $this->totalUSD;
                // }


                foreach ($this->payments as $payment) {
                    $this->deudaUSD -= $payment->getCurrency()->getId() == 1 ? 0 : $payment->getAmount();
                }
            }
        }
        return $this;
    }

    public function getFiscalInvoiceNumber(): ?string
    {
        return $this->fiscalInvoiceNumber;
    }

    public function setFiscalInvoiceNumber(?string $fiscalInvoiceNumber): self
    {
        $this->fiscalInvoiceNumber = $fiscalInvoiceNumber;

        return $this;
    }

    public function getInvoiceFile(): ?string
    {
        return $this->invoiceFile;
    }

    public function setInvoiceFile(?string $invoiceFile): self
    {
        $this->invoiceFile = $invoiceFile;

        return $this;
    }
}
