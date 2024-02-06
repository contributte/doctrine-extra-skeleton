<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Basic\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Book extends Entity
{

	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private int $id;

	/** @ORM\Column(type="string") */
	private string $title;

	/** @ORM\Column(type="boolean") */
	private bool $alreadyRead = false;

	/** @ORM\Column(type="string") */
	private string $createdAt;

	/** @ORM\Column(type="string", nullable=true) */
	private ?string $updatedAt = null;

	/**
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="books")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private Category $category;

	/**
	 * @var Tag[]|Collection
	 * @ORM\ManyToMany(targetEntity="Tag", mappedBy="books")
	 */
	private Collection $tags;

	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function isAlreadyRead(): bool
	{
		return $this->alreadyRead;
	}

	public function setAlreadyRead(bool $read): void
	{
		$this->alreadyRead = $read;
	}

	public function getCategory(): Category
	{
		return $this->category;
	}

	public function setCategory(Category $category): void
	{
		$this->category = $category;
	}

	/**
	 * @return Tag[]|Collection
	 */
	public function getTags(): Collection
	{
		return $this->tags;
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): ?string
	{
		return $this->updatedAt;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onPrePersist(): void
	{
		$this->createdAt = $this->getCurrentDate();
	}

	/**
	 * @ORM\PreUpdate()
	 */
	public function onPreUpdate(): void
	{
		$this->updatedAt = $this->getCurrentDate();
	}

	/**
	 * @ORM\PreRemove()
	 */
	public function onPreRemove(PreRemoveEventArgs $args): void
	{
		/*
		 * Note - remove will call SQL delete command that removes the record from DB
		 *      - event will be fired when user clicks [delete] link
		 *      - we could possibly prevent deleting in this event by throwing exception etc.
		 *      - we can also use $args->getEntityManager()
		 */
	}

}
