<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Username',
                    'autocomplete' => 'username'
                ],
                'row_attr' => [
                    'class' => 'input-group'
                ],
                'label_attr' => [
                    'class' => 'input-group-text'
                ],
                'label' => '<i class="fa fa-fw fa-user"></i>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your username should be at least {{ limit }} characters',
                        'max' => 50,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'autocomplete' => 'email',
                    'readonly' => $options['invite'] === true
                ],
                'row_attr' => [
                    'class' => 'input-group'
                ],
                'label_attr' => [
                    'class' => 'input-group-text'
                ],
                'label' => '<i class="fa fa-fw fa-envelope"></i>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email address',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Password',
                        'autocomplete' => 'new-password'
                    ],
                    'row_attr' => [
                        'class' => 'input-group'
                    ],
                    'label_attr' => [
                        'class' => 'input-group-text'
                    ],
                    'label' => '<i class="fa fa-fw fa-key"></i>',
                    'label_html' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Confirm Password',
                        'autocomplete' => 'new-password'
                    ],
                    'row_attr' => [
                        'class' => 'input-group'
                    ],
                    'label_attr' => [
                        'class' => 'input-group-text'
                    ],
                    'label' => '<i class="fa fa-fw fa-key"></i>',
                    'label_html' => true,
                ],
                'invalid_message' => 'The password fields must match.',
            ])
            ->add('company', TextType::class, [
                'mapped' => false, // Manually create the company
                'disabled' => $options['invite'] === true,
                'required' => $options['invite'] !== true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Organization'
                ],
                'row_attr' => [
                    'class' => 'input-group'
                ],
                'label_attr' => [
                    'class' => 'input-group-text'
                ],
                'label' => '<i class="fa fa-fw fa-suitcase"></i>',
                'label_html' => true,
                'constraints' => $options['invite'] !== true ? [
                    new NotBlank([
                        'message' => 'Please enter your organization name',
                    ]),
                ] : [],
            ])
            ->add('phone', TextType::class, [
                'required' => !isset($options['invite']),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Phone'
                ],
                'row_attr' => [
                    'class' => 'input-group'
                ],
                'label_attr' => [
                    'class' => 'input-group-text'
                ],
                'label' => '<i class="fa fa-fw fa-phone"></i>',
                'label_html' => true,
                'constraints' => $options['invite'] !== true ? [
                    new NotBlank([
                        'message' => 'Please enter your phone number',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9\+\-\(\)\s]+$/',
                        'message' => 'Please enter a valid phone number',
                    ]),
                ] : [],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ],
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'label' => 'I agree to the <a href="/terms-and-conditions">Terms of Service</a> & <a href="/privacy-policy">Privacy Policy</a>',
                'label_html' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You must agree to our terms and privacy policy.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'invite' => false,
            'attr' => [
                'class' => 'row g-3'
            ]
        ]);

        $resolver->setAllowedTypes('invite', 'bool');
    }
}
