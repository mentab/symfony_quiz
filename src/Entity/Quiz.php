<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Quiz
{
	private Collection $questions;

	public function __construct()
	{
		$this->questions = new ArrayCollection();
	}

	public function getQuestions(): Collection
	{
		return $this->questions;
	}

	public function addQuestion(Question $question): static
	{
		$this->questions->add($question);

		return $this;
	}
}