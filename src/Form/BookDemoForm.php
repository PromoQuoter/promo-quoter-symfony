<?php

namespace App\Form;

use App\Entity\BookDemo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class BookDemoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('full_name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your full name.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('organization', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your organization name.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email address.',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email address.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your phone number.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('date', DateType::class, [
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a date.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('time', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    '11:00 AM' => '11:00 AM',
                    '12:30 PM' => '12:30 PM',
                    '02:00 PM' => '02:00 PM',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a time.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('platform', ChoiceType::class, [
                'choices' => [
                    'Email' => 'Email',
                    'Skype' => 'Skype',
                    'Zoom' => 'Zoom',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a platform.',
                    ]),
                    new Choice([
                        'choices' => ['Email', 'Skype', 'Zoom'],
                        'message' => 'Please select a valid platform.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('platform_username', TextType::class, [
                'label' => 'Platform Username (optional)',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('notes', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'style' => 'height: 100px;',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Request a Demo',
                'attr' => [
                    'class' => 'btn btn-promo w-100',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookDemo::class,
            'csrf_protection' => true,
        ]);
    }
} 