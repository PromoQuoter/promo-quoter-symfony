<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginForm;
use App\Form\MagicLinkRequestForm;
use App\Form\RegistrationForm;
use App\Notifier\CustomLoginLinkNotification;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LogicException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Mime\Address;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class AuthController extends AbstractController
{
    private const RECAPTCHA_URL = 'https://www.google.com/recaptcha/api/siteverify';
    private const RECAPTCHA_SECRET = '6LcR4HwpAAAAAJQOPZWgGXnYBWXzQKXFwzGRuAkD';

    public function __construct(
        private readonly EmailVerifier $emailVerifier,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    #[Route('/auth/login', name: 'app_login')]
    public function login(
        Request $request,
        UserRepository $userRepository,
        Security $security
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(LoginForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->findOneBy(['email' => $data['email']]);

            if (!$user) {
                $this->addFlash('error', 'Invalid credentials.');
                return $this->render('controllers/auth/login.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            if (!$this->passwordHasher->isPasswordValid($user, $data['password'])) {
                $this->addFlash('error', 'Invalid credentials.');
                return $this->render('controllers/auth/login.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            // Manual authentication
            return $security->login($user, 'form_login');
        }

        return $this->render('controllers/auth/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/auth/logout', name: 'app_logout')]
    public function logout(): void
    {
        // This method can be blank - it will be intercepted by the logout key on your firewall
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/auth/check', name: 'app_auth_check')]
    public function check(): never
    {
        // This method can be blank - it will be intercepted by the firewall
        throw new LogicException('This method can be blank - it will be intercepted by the firewall.');
    }

    #[Route('/auth/magic-link', name: 'app_magic_link')]
    public function requestMagicLink(
        LoginLinkHandlerInterface $loginLinkHandler,
        UserRepository            $userRepository,
        Request                   $request,
        NotifierInterface         $notifier
    ): Response
    {
        $form = $this->createForm(MagicLinkRequestForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('error', 'No account found with this email address.');
                return $this->render('controllers/auth/request_magic_link.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            try {
                $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

                // create a notification based on the login link details
                $notification = new CustomLoginLinkNotification(
                    $loginLinkDetails,
                    'Sign in to PromoQuoter',
                );

                // create a recipient for this user
                $recipient = new Recipient($user->getEmail());

                // send the notification to the user
                $notifier->send($notification, $recipient);

                return $this->render('controllers/auth/magic_link_sent.twig');
            } catch (Exception $e) {
                $this->addFlash('error', 'An error occurred while sending the login link. Please try again.');
                return $this->render('controllers/auth/request_magic_link.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        }

        return $this->render('controllers/auth/request_magic_link.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/auth/signup', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('admin@promoquoter.com', 'PromoQuoter'))
                    ->to((string)$user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('emails/register_confirmation.html.twig')
            );

            // do anything else you need here, like send an email

            return $this->render('controllers/auth/register_success.html.twig');
        }

        return $this->render('controllers/auth/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/auth/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_login');
    }
}
