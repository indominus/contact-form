<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender', TextType::class, [
                'label' => 'От',
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank(),
                    new \Symfony\Component\Validator\Constraints\Email()
                ]
            ])
            ->add('receiver', TextType::class, [
                'label' => 'Получател',
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank(),
                    new \Symfony\Component\Validator\Constraints\Email()
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Тема',
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank()
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Съобщение',
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank()
                ]
            ])
            ->add('phpmailer', SubmitType::class, [
                'label' => 'PHPMailer',
                'attr' => ['class' => 'btn btn-sm btn-info']
            ])
            ->add('swiftmailer', SubmitType::class, [
                'label' => 'SwiftMailer',
                'attr' => ['class' => 'btn btn-sm btn-info']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }
}
