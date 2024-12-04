<?php

namespace App\Content\Post;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class PostController extends AbstractController
{
    #[Route(name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAllOrderedAntichronologically(),
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        $commentForm = $this->createForm(CommentType::class);

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
