<?php

namespace App\Management\Comment;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comment/admin')]
final class CommentAdminController extends AbstractController
{
    #[Route(name: 'app_comment_admin_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment_admin/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_comment_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_comment_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment_admin/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_admin_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment_admin/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comment_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment_admin/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comment_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
