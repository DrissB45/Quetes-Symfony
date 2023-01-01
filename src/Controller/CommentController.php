<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $commentRepository->save($comment, true);

            // Redirect to categories list
            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('comment/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->getUser() !== $comment->getAuthor() && $this->getUser()->getRoles() !== ["ROLE_ADMIN"]) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas l\'auteur de ce commentaire !');
        }

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
            $this->addFlash('danger', 'Le commentaire a été supprimé !');
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }
}
