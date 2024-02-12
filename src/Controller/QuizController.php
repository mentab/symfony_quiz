<?php

namespace App\Controller;

use App\Service\QuizService;
use App\Form\QuizType;
use App\Form\QuizParamsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Event\BeforeStartQuizEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[Route('/quiz', name: 'quiz_')]
class QuizController extends AbstractController
{
	#[Route('/', name: 'home')]
	public function home(QuizService $quizService, Request $request, EventDispatcherInterface $dispatcher): Response
	{
		$quizParams = $quizService->createQuizParams();

		$form = $this->createForm(QuizParamsType::class, $quizParams, [
			//'categories' => $quizParams->getCategories()
		]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$event = new BeforeStartQuizEvent($quizParams);
			$dispatcher->dispatch($event);

			return $this->redirectToRoute('quiz_start');
		}

		return $this->render('quiz/home.html.twig', [
			'form' => $form
		]);
	}

	#[Route('/start', name: 'start')]
	public function start(QuizService $quizService, Request $request): Response
	{
		$session = $request->getSession();

		$quiz = $quizService->createQuiz();

		$form = $this->createForm(QuizType::class, $quiz);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			return $this->redirectToRoute('quiz_results');
		}

		return $this->render('quiz/start.html.twig', [
			'form' => $form
		]);
	}

	#[Route('/results', name: 'results')]
	public function results(Request $request): Response
	{
		$session = $request->getSession();

		if (!$session->has('quiz')) {
			return $this->redirectToRoute('quiz_show');
		}

		$quiz = $session->get('quiz');

		$session->remove('quiz');

		return $this->render('quiz/results.html.twig', [
			'quiz' => $quiz
		]);
	}
}
