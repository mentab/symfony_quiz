<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class QuestionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
			$form = $event->getForm();
			$question = $event->getData();

			if ($question instanceof Question) {
				$form
					->add('userAnswer', ChoiceType::class, [
						'choices' => $question->getMixedAnswers(),
						'choice_label' => function ($choice, $key, $value) {
							return $value;
						},
						'multiple' => false,
						'expanded' => true,
						'label' => $question->getQuestion(),
						'help' => sprintf(
							'Category: %s, Difficulty: %s, Type: %s',
							$question->getCategory(),
							$question->getDifficulty(),
							$question->getType()
						),
					]);
			}
		});
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Question::class,
		]);
	}
}
