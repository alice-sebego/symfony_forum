<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Topic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/edit/{id}", name="message_edit")
     */
    public function editMessage(Message $message, Request $request, ManagerRegistry $doctrine):Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createFormBuilder($message)
        ->add('content', TextareaType::class, [
            'label'=> 'Content : '
        ])
        ->add('Submit', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('show_topic', [
                'id'=> $message->getTopic()->getId()
            ]);
        }
        return $this->render('message/edit.html.twig', [
            'controller_name' => 'MessageController',
            'messageForm'=> $form->createView()
        ]);
    }

    /**
     * @Route("/message", name="app_message")
     */
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}
