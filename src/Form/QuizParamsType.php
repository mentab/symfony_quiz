<?php

namespace App\Form;

use App\Entity\QuizParams;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class QuizParamsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('amount', ChoiceType::class, [
				'placeholder' => 10,
				'choices' => QuizParams::getAmounts(),
				'choice_label' => function ($value, $key, $index) {
					return $value;
				},
			])
			//->add('category', ChoiceType::class, [
			//	'placeholder' => 'Choose a category',
			//	'choices' => $options['categories'],
			//	'choice_label' => function ($value, $key, $index) {
			//		return $value;
			//	},
			//])
			->add('difficulty', ChoiceType::class, [
				'placeholder' => 'Choose an option',
				'choices' => QuizParams::getDifficulties(),
				'choice_label' => function ($value, $key, $index) {
					return $value;
				},
			])
			->add('type', ChoiceType::class, [
				'placeholder' => 'Choose an option',
				'choices' => QuizParams::getTypes(),
				'choice_label' => function ($value, $key, $index) {
					return $value;
				},
			])
			->add('save', SubmitType::class);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => QuizParams::class,
			//'categories' => []
		]);

		//$resolver->setAllowedTypes('categories', 'array');
	}
}
