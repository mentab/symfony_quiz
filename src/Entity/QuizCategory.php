<?php

namespace App\Entity;

class QuizCategory
{
	private int $id;

	private string $name;

	public function __construct(int $id, string $name) {
		$this->id = $id;
		$this->name = $name;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId($id): static
	{
		$this->id = $id;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): static
	{
		$this->name = $name;

		return $this;
	}
}
