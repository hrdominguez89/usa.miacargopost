<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Table(name: '`tb_invoice_payment`')]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'payments')]
    #[ORM\JoinColumn(name: 'invoice_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Invoice $invoice;

    #[ORM\Column(name: 'amount', type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $amount = null;

    #[ORM\Column(name: 'payment_type', type: Types::STRING, length: 50)]
    #[Assert\Length(max: 50)]
    #[Assert\NotBlank]
    private ?string $paymentType = null;

    #[ORM\Column(name: 'voucher', type: Types::STRING, length: 100)]
    #[Assert\Length(max: 100)]
    #[Assert\NotBlank]
    private ?string $voucher = null;

    #[ORM\Column(name: 'voucher_file', type: 'string', length: 255, nullable: true)]
    private ?string $voucherFile = null;

    #[ORM\Column(name: 'voucher_url_file', type: 'text', nullable: true)]
    private ?string $voucherUrlFile = null;

    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'date_updated', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdated;

    #[ORM\Column(name: 'note', type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    private ?Currency $currency = null;

    /**
     * @param Invoice|null $invoice
     */
    public function __construct(?Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @param string|null $paymentType
     * @return $this
     */
    public function setPaymentType(?string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVoucher(): ?string
    {
        return $this->voucher;
    }

    /**
     * @param string|null $voucher
     * @return $this
     */
    public function setVoucher(?string $voucher): self
    {
        $this->voucher = $voucher;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVoucherFile(): ?string
    {
        return $this->voucherFile;
    }

    /**
     * @param string|null $voucherFile
     * @return $this
     */
    public function setVoucherFile(?string $voucherFile): self
    {
        $this->voucherFile = $voucherFile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVoucherUrlFile(): ?string
    {
        return $this->voucherUrlFile;
    }

    /**
     * @param string|null $voucherUrlFile
     * @return $this
     */
    public function setVoucherUrlFile(?string $voucherUrlFile): self
    {
        $this->voucherUrlFile = $voucherUrlFile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     * @return $this
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

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
    public function setDateUpdated(?\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     * @return $this
     */
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
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
