<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Form;

use Application\Feedback\Command\UpdateFeedbackCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateFeedbackForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateFeedbackForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'feedback.forms.labels.content',
                'help' => "vous n'avez que 300 caractères pour exprimer votre feedback",
            ])
            ->add('promotion', TextType::class, [
                'label' => 'feedback.forms.labels.promotion',
                'disabled' => true,
            ])
            ->add('is_anonymous', CheckboxType::class, [
                'label' => 'feedback.forms.labels.is_anonymous',
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateFeedbackCommand::class,
            'translation_domain' => 'feedback',
        ]);
    }
}
