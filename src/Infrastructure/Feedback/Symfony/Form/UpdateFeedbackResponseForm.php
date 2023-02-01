<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Form;

use Application\Feedback\Command\UpdateFeedbackResponseCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateFeedbackResponseForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateFeedbackResponseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'feedback.forms.labels.response',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateFeedbackResponseCommand::class,
            'translation_domain' => 'feedback',
        ]);
    }
}
