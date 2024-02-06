<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Basic\Repository\TagRepository;
use App\Model\Database\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag extends Entity
{

	#[ORM\Column(name: 'id', type: 'integer')]
	#[ORM\Id]
	#[ORM\GeneratedValue()]
	private int $id;

	#[ORM\Column(type: 'string')]
	private string $title;

	/** @var Book[]|Collection */
	#[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'tags')]
	private Collection $books;

	/**
	 * Tag constructor
	 */
	public function __construct()
	{
		$this->books = new ArrayCollection();
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

	/**
	 * @return Book[]|Collection
	 */
	public function getBooks(): Collection
	{
		return $this->books;
	}

}
