<?php

namespace App\Controller;

use App\Entity\BookDemo;
use App\Entity\ContactUs;
use App\Entity\UsersToDo;
use App\Form\BookDemoForm;
use App\Repository\BookDemoRepository;
use App\Repository\ClientsFeedbackRepository;
use App\Repository\FaqRepository;
use App\Repository\UsersToDoRepository;
use Carbon\Carbon;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Ulid;

class HomeController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface    $entityManager,
        private readonly Security                  $security,
        private readonly ClientsFeedbackRepository $clientFeedbackRepository,
        private readonly FaqRepository             $faqRepository,
        private readonly UsersToDoRepository       $todoRepository,
        private readonly MailerInterface           $mailer,
    )
    {
    }

    #[Route('/', name: 'app_home')]
    #[Template('controllers/home/index.html.twig')]
    public function index(): array
    {
        $clientsFeedback = $this->clientFeedbackRepository->findActive();

        return [
            'all_clients_feedback' => $clientsFeedback
        ];
    }

    #[Route('/pricing', name: 'app_pricing')]
    #[Template('controllers/home/pricing.html.twig')]
    public function pricing(): array
    {
        return [];
    }

    #[Route('/terms-and-conditions', name: 'app_terms')]
    #[Template('controllers/home/terms_and_conditions.html.twig')]
    public function termsAndConditions(): array
    {
        return [];
    }

    #[Route('/privacy-policy', name: 'app_privacy')]
    #[Template('controllers/home/privacy_policy.html.twig')]
    public function privacyPolicy(): array
    {
        return [];
    }

    #[Route('/about', name: 'app_about')]
    #[Template('controllers/home/about.html.twig')]
    public function about(): array
    {
        return [];
    }

    #[Route('/screenshots', name: 'app_screenshots')]
    #[Template('controllers/home/screenshots.html.twig')]
    public function screenshots(): array
    {
        return [];
    }

    #[Route('/free-trial', name: 'app_free_trial')]
    #[Template('controllers/home/free_trial.html.twig')]
    public function freeTrial(): array
    {
        return [];
    }

    #[Route('/faq', name: 'app_faq')]
    #[Template('controllers/home/faq.html.twig')]
    public function faq(): array
    {
        return [
            'all_faq' => $this->faqRepository->findActive()
        ];
    }

    #[Route('/contact-us', name: 'app_contact_us')]
    #[Template('controllers/home/contact_us.html.twig')]
    public function contactUs(): array
    {
        return [];
    }

    #[Route('/drop-message', name: 'app_drop_message', methods: ['POST'])]
    public function dropMessage(Request $request): JsonResponse
    {
        // Verify reCAPTCHA
        $recaptchaResponse = $request->request->get('g-recaptcha-response');
        $secretKey = "6LcR4HwpAAAAACreVUFtN2YZyxPNT-qrknDJOcHV";

        $response = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $recaptchaResponse
        );
        $responseKeys = json_decode($response, true);

        if (!$responseKeys['success']) {
            return $this->json([
                'status' => 'error',
                'message' => 'reCAPTCHA verification failed. Please try again.'
            ]);
        }

        $contact = new ContactUs();
        $contact->setName($request->request->get('name'))
            ->setEmail($request->request->get('email'))
            ->setPhone($request->request->get('phone'))
            ->setSubject($request->request->get('subject'))
            ->setMsg($request->request->get('msg'))
            ->setEntryDate(new DateTimeImmutable());

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        // Send email notification
        $this->sendContactNotificationEmail($contact);

        return $this->json([
            'status' => 'success',
            'last_insert_id' => $contact->getId(),
            'message' => 'Your message has been sent successfully!'
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/book-demo', name: 'app_book_demo')]
    public function bookDemo(Request $request): Response
    {
        $booking = new BookDemo();
        $form = $this->createForm(BookDemoForm::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Generate a unique identifier
            $booking->setCuid(new Ulid());

            // Set the date/time
            $date = $form->get('date')->getData();
            $time = $form->get('time')->getData();
            $datetime = new DateTimeImmutable($date->format('Y-m-d') . ' ' . $time);
            $booking->setDate($datetime);

            // Save to database
            $this->entityManager->persist($booking);
            $this->entityManager->flush();

            // Send confirmation emails
            $this->sendBookingConfirmationEmail($booking);
            $this->sendBookingAdminNotificationEmail($booking);

            return $this->redirectToRoute('app_book_demo_thanks', [
                'cuid' => $booking->getCuid()
            ]);
        }

        return $this->render('controllers/home/book_demo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/book-demo/thanks/{cuid}', name: 'app_book_demo_thanks')]
    public function bookDemoThanks(string $cuid, BookDemoRepository $bookDemoRepository): Response
    {
        $booking = $bookDemoRepository->findOneBy(['cuid' => $cuid]);

        if (!$booking) {
            $this->addFlash('error', 'Sorry, we could not find your booking.');
            return $this->redirectToRoute('app_book_demo');
        }

        return $this->render('controllers/home/book_demo_success.html.twig', [
            'booking' => $booking
        ]);
    }

    // TODO: Move these someday
    #[Route('/todo/add', name: 'app_add_todo', methods: ['POST'])]
    public function addTodo(Request $request): JsonResponse
    {
        $todoName = $request->request->get('todoname');
        $user = $this->security->getUser();

        $todo = new UsersToDo();
        $todo->setUserId($user)
            ->setTodo($todoName);

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return $this->json(['id' => $todo->getId()]);
    }

    #[Route('/todo/list', name: 'app_todo_list', methods: ['POST'])]
    public function todoList(Request $request): JsonResponse
    {
        // TODO: Check if null
        $userId = $this->security->getUser()?->getUserIdentifier();
        $draw = $request->request->getInt('draw');

        // TODO: Better way of doing this
        $todos = $this->todoRepository->getDatatables($request->request->all(), $userId);
        $totalRecords = $this->todoRepository->countAll($userId);
        $filteredRecords = $this->todoRepository->countFiltered($request->request->all(), $userId);

        $data = [];
        foreach ($todos as $todo) {
            $data[] = [
                'name' => $todo->getTodo() . ' <small class="pull-right label label-danger"><i class="fa fa-clock-o"></i> '
                    . Carbon::instance($todo->getModifiedDate())->diffForHumans(['parts' => 1]) . '</small>',
                'action_edit' => sprintf(
                    '<a onclick="delete_todo(%d)" href="javascript:void(0);" class="btn btn-xs btn-info pull-right" style="color:#fff"><i class="fa fa-trash"></i></a>',
                    $todo->getId()
                )
            ];
        }

        return $this->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    #[Route('/todo/delete', name: 'app_delete_todo', methods: ['POST'])]
    public function deleteTodo(Request $request): JsonResponse
    {
        $todoId = $request->request->getInt('todoId');
        $todo = $this->todoRepository->find($todoId);

        if ($todo) {
            $todo->setDeleteFlag('Y');
            $this->entityManager->persist($todo);
            $this->entityManager->flush();
        }

        return $this->json(['success' => true]);
    }

    private function sendBookingConfirmationEmail(BookDemo $booking): void
    {
        // TODO: Implement
//        $email = (new Email())
//            ->from($this->adminEmail)
//            ->to($booking->getEmail())
//            ->subject('Your booking is confirmed')
//            ->html(
//                $this->renderView('emails/book_demo_user.html.twig', [
//                    'booking' => $booking
//                ])
//            );
//
//        $this->mailer->send($email);
    }

    private function sendBookingAdminNotificationEmail(BookDemo $booking): void
    {
        // TODO: Implement
//        $email = (new Email())
//            ->from($this->adminEmail)
//            ->to($this->adminEmail)
//            ->subject('New demo booking')
//            ->html(
//                $this->renderView('emails/book_demo_admin.html.twig', [
//                    'booking' => $booking
//                ])
//            );
//
//        $this->mailer->send($email);
    }

    private function sendContactNotificationEmail(ContactUs $contact): void
    {
        // TODO: Implement using Symfony Mailer
//        $message = $this->renderView('emails/contact_notification.html.twig', [
//            'contact' => $contact
//        ]);

        // You'll need to setup Symfony Mailer and implement the actual email sending logic here
    }
} 