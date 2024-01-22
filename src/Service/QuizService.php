<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Service\ApiService;
use Symfony\Component\HttpFoundation\RequestStack;

class QuizService
{
	public function __construct(
		private ApiService $apiService,
		private RequestStack $requestStack
	) {}

	private function decodeHtmlEntities(string $string): string
	{
		return html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	}

	public function createQuiz(): Quiz
	{
		$session = $this->requestStack->getSession();

		if ($session->has('quiz')) {
			return $session->get('quiz');
		}

		$quizData = $this->apiService->fetchQuizData();
		$quiz = new Quiz();

		foreach ($quizData as $result) {
			$question = new Question(
				$result['type'],
				$result['difficulty'],
				$result['category'],
				$this->decodeHtmlEntities($result['question']),
				$this->decodeHtmlEntities($result['correct_answer']),
				array_map([$this, 'decodeHtmlEntities'], $result['incorrect_answers'])
			);

			$quiz->addQuestion($question);
		}

		
		$session->set('quiz', $quiz);

		return $quiz;
	}
}
