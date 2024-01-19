<?php

namespace App\Controller;

use App\Service\QuizService;
use App\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quiz', name: 'quiz_')]
class QuizController extends AbstractController
{
	#[Route('/show', name: 'show')]
	public function showQuiz(QuizService $quizService, Request $request): Response
	{
		$quiz = $quizService->createQuizFromApi();

		$form = $this->createForm(QuizType::class, $quiz);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->get('session')->set('quiz', $quiz);

			return $this->redirectToRoute('quiz_results');
		}

		return $this->render('quiz/quiz.html.twig', [
			'form' => $form
		]);
	}

	#[Route('/results', name: 'results')]
	public function quiz(QuizService $quizService): Response
	{
		$quiz = $this->get('session')->get('quiz');

		var_dump($quiz);

		return $this->render('quiz/results.html.twig', [
			'quiz' => $quiz
		]);
	}
}
