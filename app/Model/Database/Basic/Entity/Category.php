<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Basic\Repository\CategoryRepository")
 */
class Category extends Entity
{

	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private int $id;

	/** @ORM\Column(type="string") */
	private string $title;

	/**
	 * @var Book[]|Collection
	 * @ORM\OneToMany(targetEntity="Book", mappedBy="category")
	 */
	private Collection $books;

	/**
	 * Category constructor
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
