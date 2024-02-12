<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\QuizCategory;
use App\Entity\QuizParams;
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

	public function createQuizParams(): QuizParams
	{
		$session = $this->requestStack->getSession();

		if ($session->has('params')) {
			return $session->get('params');
		}

		$quizParams = new QuizParams();

		$quizCategories = $this->apiService->fetchQuizCategories();

		foreach ($quizCategories as $category) {
			$quizCategory = new QuizCategory(
				$category['id'],
				$category['name']
			);

			$quizParams->addCategory($quizCategory);
		}

		$session->set('params', $quizParams);

		return $quizParams;
	}

	public function createQuiz(): Quiz
	{
		$session = $this->requestStack->getSession();

		if ($session->has('quiz')) {
			return $session->get('quiz');
		}

		$quiz = new Quiz();

		$quizData = $this->apiService->fetchQuizData();

		foreach ($quizData as $data) {
			$question = new Question(
				$data['type'],
				$data['difficulty'],
				$data['category'],
				$this->decodeHtmlEntities($data['question']),
				$this->decodeHtmlEntities($data['correct_answer']),
				array_map([$this, 'decodeHtmlEntities'], $data['incorrect_answers'])
			);

			$quiz->addQuestion($question);
		}

		
		$session->set('quiz', $quiz);

		return $quiz;
	}
}
