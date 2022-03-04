<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Form\TopicSearchType;
use App\Repository\ReponseRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
    #[Route('/topic/details/{id}', name: 'app_topic')]
    public function index(int $id, TopicRepository $topics, Request $rq, EntityManagerInterface $manager, ReponseRepository $reponses): Response
    {
        $topic = $topics->findOneBy(['id' => $id]);
        $replies = $reponses->findBy(['topic' => $topic]);
        $form = $this->createForm(ReponseType::class);
        $form->handleRequest($rq);
        $reply = new Reponse();

        if($form->isSubmitted() && $form->isValid()){
            $reply->setContenu($form->get('contenu')->getData());
            $reply->setAuteur($this->getUser());
            $reply->setTopic($topic);

            $manager->persist($reply);
            $manager->flush();

            return $this->redirectToRoute('app_topic', ['id' => $topic->getId()]);
        }
        return $this->render('topic/index.html.twig', [
            'id' => $topic->getId(),
            'topic' => $topic,
            'ReponseForm' => $form->createView(),
            'reponses' => $replies
        ]);
    }

    #[Route('topic/details/{id}', name: 'useful')]
    public function isUseful(int $id, ReponseRepository $reponses)
    {
        $reponse = $reponses->findOneBy(['id' => $id]);
        $notes = $reponse->getNotes();
        $index = 0;
        while($notes[$index]){
            $index++;
        }
        $notes[$index] = new Note();
        $notes[$index]->setEstUtile(true);
        $notes[$index]->setNoteur($this->getUser());
        $reponse->setNoteGlobale();
        $topic = $reponse->getTopic();
        return $this->redirectToRoute('app_topic', ['id' => $topic->getId()]);
    }

    #[Route('topic/details/{id}', name: 'useless')]
    public function isUseless(int $id, ReponseRepository $reponses)
    {
        $reponse = $reponses->findOneBy(['id' => $id]);
        $notes = $reponse->getNotes();
        $index = 0;
        while($notes[$index]){
            $index++;
        }

        $notes[$index] = new Note();
        $notes[$index]->setEstUtile(false);
        $notes[$index]->setNoteur($this->getUser());
        $reponse->setNoteGlobale();
        $topic = $reponse->getTopic();
        return $this->redirectToRoute('app_topic', ['id' => $topic->getId()]);
    }

    #[Route('topic/search/{query?}', name: 'search_topics')]
    public function search(?String $query, TopicRepository $topics, Request $rq)
    {
        $form = $this->createForm(TopicSearchType::class);
        $form->handleRequest($rq);

        if($form->isSubmitted() && $form->isValid()) {
            $query = $form->getData()->getTitre();
            $results = $topics->findContaining($query);

            return $this->render('topic/search.html.twig', [
                'query' => $query,
                'results' => $query,
                'TopicSearch' => $form->createView(),
                'topics' => $results
            ]);
        } else {
            $results = $topics->findAllSorted();
            return $this->render('topic/search.html.twig', [
                'results' => null,
                'TopicSearch' => $form->createView(),
                'topics' => $results
            ]);
        }   
    }
}
