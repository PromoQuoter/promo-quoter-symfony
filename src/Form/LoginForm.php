<?php

namespace App\Form;

use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'autocomplete' => 'email'
                ],
                'row_attr' => [
                    'class' => 'input-group mb-2'
                ],
                'label_attr' => [
                    'class' => 'input-group-text'
                ],
                'label' => '<i class="fa fa-fw fa-user"></i>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email address',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                    'autocomplete' => 'current-password'
                ],
                'row_attr' => [
                    'class' => 'input-group mb-2'
                ],
                'label_attr' => [
                    'class' => 'input-group-text'
                ],
                'label' => '<i class="fa fa-fw fa-key"></i>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your password',
                    ]),
                ],
            ])
            ->add('remember_me', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'row_attr' => [
                    'class' => 'mb-2'
                ],
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'action_name' => 'login',
                'constraints' => new Recaptcha3([
                    'message' => 'The captcha verification failed. Please try again.',
                ]),
            ])
        ;
    }
} 