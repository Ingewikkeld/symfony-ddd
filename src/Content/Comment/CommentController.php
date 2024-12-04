<?php

namespace App\Content\Comment;

use App\Content\Post\CommentType;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }
    #[Route('/', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/add/{post}', name: 'app_comment_add', methods: ['POST'])]
    public function add(Request $request, Post $post): Response
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setPublishedAt(new DateTimeImmutable('now'));

            $this->entityManager->persist($comment);

            $post->setCommentCount($post->getCommentCount() + 1);

            $this->entityManager->persist($post);

            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
    }
}
