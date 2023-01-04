<?php

namespace App\Controller;

use App\Entity\Topic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topic")
 */
class TopicController extends AbstractController
{
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
