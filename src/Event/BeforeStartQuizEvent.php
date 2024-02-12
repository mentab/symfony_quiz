<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\QuizParams;

class BeforeStartQuizEvent extends Event
{
	public function __construct(private QuizParams $quizParams) {
	}

	public function getQuizParams(): QuizParams
    {
        return $this->quizParams;
    }
}