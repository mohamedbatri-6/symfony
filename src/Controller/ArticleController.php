<?php

// src/Controller/ArticleController.php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article_list", methods={"GET"})
     */
    public function list(ArticleRepository $articleRepository): Response
    {
        // Utiliser le repository pour récupérer tous les articles
        $articles = $articleRepository->findBy([], ['createdAt' => 'DESC']);  // Articles triés par date décroissante

        // Renvoyer les articles au template Twig
        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function show(int $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);

        if (!$article) {
            return $this->json(['error' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->render('article_show.html.twig', [
            'article' => $article,
        ]);
    }
}

