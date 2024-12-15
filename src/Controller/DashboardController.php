<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();

        $commentsByArticle = [];
        foreach ($articles as $article) {
            $commentsByArticle[$article->getId()] = $entityManager
                ->getRepository(Comment::class)
                ->findByArticle($article->getId());
        }

        // Gestion de l'ajout d'un commentaire
        if ($request->isMethod('POST')) {
            $articleId = $request->request->get('article_id');
            $content = $request->request->get('content');

            if ($this->getUser()) {
                $article = $entityManager->getRepository(Article::class)->find($articleId);
                if ($article) {
                    $comment = new Comment();
                    $comment->setContent($content);
                    $comment->setCreatedAt(new \DateTime());
                    $comment->setUser($this->getUser());
                    $comment->setArticle($article);

                    $entityManager->persist($comment);
                    $entityManager->flush();

                    $this->addFlash('success', 'Commentaire ajouté avec succès.');
                    return $this->redirectToRoute('dashboard');
                }
            } else {
                $this->addFlash('error', 'Vous devez être connecté pour ajouter un commentaire.');
            }
        }

        return $this->render('dashboard.html.twig', [
            'articles' => $articles,
            'commentsByArticle' => $commentsByArticle,
        ]);
    }

    
}
