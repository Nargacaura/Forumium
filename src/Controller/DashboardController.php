<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\NewTopicType;
use App\Repository\TopicRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TopicRepository $topics): Response
    {
        
        $topic = $topics->findBy(['auteur' => $this->getUser()]);
        return $this->render('dashboard/index.html.twig', [
            'topics' => $topic
        ]);
    }

    #[Route('/new', name: 'new_topic')]
    public function newTopic(Request $rq, EntityManagerInterface $manager): Response
    {
        $topic = new Topic();
        $form = $this->createForm(NewTopicType::class);
        $form->handleRequest($rq);

        if($form->isSubmitted() && $form->isValid()){
            $topic->setTitre($form->get('titre')->getData());
            $topic->setDescription($form->get('description')->getData());
            $topic->setAuteur($this->getUser());

            $manager->persist($topic);
            $manager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/new.html.twig', [
            'newTopicForm' => $form->createView()
        ]);
    }
}
