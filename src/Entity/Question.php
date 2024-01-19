<?php

namespace App\Entity;

class Question
{
	private string $type;
	private string $difficulty;
	private string $category;
	private string $question;
	private string $correctAnswer;
	private array $incorrectAnswers;
	private string $userAnswer;

	public function __construct(
		string $type,
		string $difficulty,
		string $category,
		string $question,
		string $correctAnswer,
		array $incorrectAnswers)
	{
		$this->type = $type;
		$this->difficulty = $difficulty;
		$this->category = $category;
		$this->question = $question;
		$this->correctAnswer = $correctAnswer;
		$this->incorrectAnswers = $incorrectAnswers;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getDifficulty(): string
	{
		return $this->difficulty;
	}

	public function getCategory(): string
	{
		return $this->category;
	}

	public function getQuestion(): string
	{
		return $this->question;
	}

	public function getCorrectAnswer(): string
	{
		return $this->correctAnswer;
	}

	public function getIncorrectAnswers(): array
	{
		return $this->incorrectAnswers;
	}

	public function getMixedAnswers(): array
	{
		$mixedAnswers = array_merge([$this->getCorrectAnswer()], $this->getIncorrectAnswers());
        shuffle($mixedAnswers);

        return $mixedAnswers;
	}

	public function getUserAnswer(): string
	{
		return $this->userAnswer;
	}

	public function setUserAnswer(string $userAnswer): void
	{
		$this->userAnswer = $userAnswer;
	}
}