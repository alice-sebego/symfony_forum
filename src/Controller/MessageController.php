<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/add", name="message_add")
     * @Route("/message/{id}/edit", name="message_edit")
     */
    public function addEditMessage(Message $message = null, Request $request, ManagerRegistry $doctrine):Response
    {
        $entityManager = $doctrine->getManager();
        if(!$message){
            $message = new Message();
        }
        $form = $this->createFormBuilder($message)
        ->add('content', TextType::class, [
            'label'=> 'Content : '
        ])
        ->add('Submit', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('app_message');
        }
        return $this->render('message/edit.html.twig', [
            'controller_name' => 'MessageController',
            'form'=> $form->createView()
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
