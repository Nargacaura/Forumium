<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TopicRepository $topics): Response
    {
        $allTopics = $topics->findAllSorted();
        return $this->render('home/index.html.twig', [
            'topics' => $allTopics
        ]);
    }
}
