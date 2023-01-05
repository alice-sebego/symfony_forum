<?php

namespace App\Controller;

use App\Entity\Topic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topics")
 */
class TopicController extends AbstractController
{
    /**
     * @Route("/add", name="app_topic_add")
     * @Route("/{id}/edit", name="app_topic_edit")
     */
    public function addEditTopic(Topic $topic = null, Request $request, ManagerRegistry $doctrine): Response{

        $entityManager = $doctrine->getManager();
        if(!$topic){
            $topic = new Topic();
        }

        $form = $this->createFormBuilder($topic)
            ->add('title', TextType::class, [
                'label'=> 'Title : '
            ])
            ->add('content', TextareaType::class, [
                'label'=> 'Content : '
            ])
            ->add('Valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('app_topic');
        }

        return $this->render('topic/edit.html.twig', [
            'topicForm'=> $form->createView()
        ]);

    }

    /**
     * @Route("/", name="app_topic")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Topic::class);
        $topics = $repository->getAllByDate();
        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
            'topics'=> $topics
        ]);
    }

    /**
     * @Route("/{id}", name="show_topic")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Topic::class);
        $topic = $repository->find($id);
        return $this->render('topic/show.html.twig', [
            'controller_name' => 'TopicController',
            'topic'=> $topic
        ]);
    }

}
