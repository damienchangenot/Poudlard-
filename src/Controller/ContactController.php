<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ContactController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $defaultData = [];

        $form = $this->createFormBuilder($defaultData)
            ->add('title', TextType::class,[
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "title" and "message" keys
            $data = $form->getData();
            $email = (new Email())
            ->from($this->getUser()->getEmail())
                ->to($this->getParameter('mailer_admin'))
                ->subject($data['title'])
                ->html($this->renderView('contact/contactEmail.html.twig', ['message' => $data['message']]));
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('home_index');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}