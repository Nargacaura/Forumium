<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TopicRepository $topics, PaginatorInterface $pagination, Request $rq): Response
    {
        $allTopics = $pagination->paginate($topics->findAllSorted(), $rq->query->getInt('page', 1), 12);
        return $this->render('home/index.html.twig', [
            'topics' => $allTopics
        ]);
    }
}
