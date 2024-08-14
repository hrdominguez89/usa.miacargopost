<?php

namespace App\Entity;

use App\Repository\ReminderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReminderRepository::class)]
#[ORM\Table(name: '`tb_reminder`')]
class Reminder
{
    const TYPES = ['DANGER', 'DARK', 'INFO', 'PRIMARY', 'SUCCESS', 'WARNING'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Assert\Choice(choices: Reminder::TYPES)]
    #[Assert\NotBlank]
    private ?string $typeReminder;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'date_updated', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdated;

    #[ORM\Column(nullable: true)]
    private ?int $hoursWorked = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $tags = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(min: 2, max: 500)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Url]
    private ?string $url = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $notification;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $allDay;

    #[ORM\ManyToOne(targetEntity: '\App\Entity\User', inversedBy: 'reminders')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?User $user = null;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();

        $this->typeReminder = 'info';

        $this->allDay = false;
        $this->notification = false;
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): Reminder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return $this
     */
    public function setUrl(?string $url): Reminder
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllDay(): ?bool
    {
        return $this->allDay;
    }

    /**
     * @param bool|null $allDay
     * @return $this
     */
    public function setAllDay(?bool $allDay): Reminder
    {
        $this->allDay = $allDay;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeReminder(): ?string
    {
        return $this->typeReminder;
    }

    /**
     * @param string|null $typeReminder
     * @return $this
     */
    public function setTypeReminder(?string $typeReminder): Reminder
    {
        $this->typeReminder = $typeReminder;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     * @return $this
     */
    public function setLocation(?string $location): Reminder
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTimeInterface|null $dateStart
     * @return $this
     */
    public function setDateStart(?\DateTimeInterface $dateStart): Reminder
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTimeInterface|null $dateEnd
     * @return $this
     */
    public function setDateEnd(?\DateTimeInterface $dateEnd): Reminder
    {
        $this->dateEnd = $dateEnd;

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
    public function setDateCreated(\DateTimeInterface $dateCreated): Reminder
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
     * @return int|null
     */
    public function getHoursWorked(): ?int
    {
        return $this->hoursWorked;
    }

    /**
     * @param int|null $hoursWorked
     * @return $this
     */
    public function setHoursWorked(?int $hoursWorked): Reminder
    {
        $this->hoursWorked = $hoursWorked;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param string|null $tags
     * @return $this
     */
    public function setTags(?string $tags): Reminder
    {
        $this->tags = $tags;

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
     * @return $this
     */
    public function setDescription(?string $description): Reminder
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isNotification(): ?bool
    {
        return $this->notification;
    }

    /**
     * @param bool|null $notification
     * @return $this
     */
    public function setNotification(?bool $notification): Reminder
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): Reminder
    {
        $this->user = $user;

        $user?->addReminder($this);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $format = 'c'; // full ISO8601 output, like "2013-12-29T09:00:00+08:00"

        if ($this->allDay) {
            $format = 'Y-m-d'; // output like "2013-12-29"
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'end' => $this->dateStart?->format($format),
            'start' => $this->dateEnd?->format($format),
            'description' => $this->description,
            'allDay' => $this->allDay,
            'location' => $this->location,
            'className' => 'bg-soft-'.strtolower($this->typeReminder ?? 'info'),
        ];
    }
}
