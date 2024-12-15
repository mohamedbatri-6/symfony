<?php
// src/Controller/CommentController.php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comments', name: 'comments_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): Response
    {
        $comments = $em->getRepository(Comment::class)->findAll();
        return $this->json($comments, 200, [], ['groups' => 'comment']);
    }

    #[Route('/comments', name: 'add_comment', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $article = $em->getRepository(Article::class)->find($data['article_id']);
        $user = $em->getRepository(User::class)->find($data['user_id']);

        if (!$article || !$user) {
            return $this->json(['error' => 'Invalid article or user'], 400);
        }

        $comment = new Comment();
        $comment->setContent($data['content']);
        $comment->setArticle($article);
        $comment->setUser($user);

        $em->persist($comment);
        $em->flush();

        return $this->json($comment, 201, [], ['groups' => 'comment']);
    }
}
