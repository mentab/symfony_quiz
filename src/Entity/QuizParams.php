<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class QuizParams
{
	#[Assert\NotBlank]
	#[Assert\Choice(callback: 'getAmounts', message: 'Choose a valid amount.')]
	private int $amount = 10;

	// private ?int $category = null;

	#[Assert\Choice(callback: 'getDifficulties', message: 'Choose a valid difficulty.')]
	private ?string $difficulty = null;


	#[Assert\Choice(callback: 'getTypes', message: 'Choose a valid type.')]
	private ?string $type = null;

	//private Collection $categories;

	public function __construct()
	{
		//$this->categories = new ArrayCollection();
	}

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function setAmount(int $amount): static
	{
		$this->amount = $amount;

		return $this;
	}

	//public function getCategory(): ?QuizCategory
	//{
	//	return $this->category;
	//}
//
	//public function setCategory(QuizCategory $category): static
	//{
	//	$this->category = $category;
//
	//	return $this;
	//}

	public function getDifficulty(): ?string
	{
		return $this->difficulty;
	}

	public function setDifficulty(string $difficulty): static
	{
		$this->difficulty = $difficulty;

		return $this;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function setType(string $type): static
	{
		$this->type = $type;

		return $this;
	}

	public static function getAmounts(): array
	{
		return [5, 10, 25];
	}

	public static function getDifficulties(): array
	{
		return ['easy', 'medium', 'hard'];
	}

	public static function getTypes(): array
	{
		return ['multiple', 'boolean'];
	}

	//public function getCategories(): array
	//{
	//	return $this->categories->toArray();
	//}
//
	//public function addCategory(QuizCategory $category): static
	//{
	//	$this->categories->add($category);
//
	//	return $this;
	//}
}