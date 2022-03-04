<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
    #[Route('/topic/{id}', name: 'app_topic')]
    public function index(int $id, TopicRepository $topics): Response
    {
        $topic = $topics->findOneBy(['id' => $id]);
        return $this->render('topic/index.html.twig', [
            'topic' => $topic,
        ]);
    }
}
