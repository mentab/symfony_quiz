<?php

namespace App\EventSubscriber;

use App\Event\BeforeStartQuizEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

class QuizPreStartSubscriber implements EventSubscriberInterface
{
	public function __construct(private LoggerInterface $logger) {}

	public static function getSubscribedEvents(): array
	{
		return [
			BeforeStartQuizEvent::class => 'onStartedQuiz',
		];
	}

	public function onStartedQuiz(BeforeStartQuizEvent $event): void
	{	
		$quizParams = $event->getQuizParams();

		$this->logger->debug('A Quiz of type {quizType} and difficulty {quizDifficulty} has started', [
			'quizType' => $quizParams->getType(),
			'quizDifficulty' => $quizParams->getDifficulty()
		]);
	}
}