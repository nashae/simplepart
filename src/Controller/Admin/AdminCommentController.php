<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Form\CommentEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * permet a l'admin de modifier un commentaire
     * 
     * @Route("admin/comment/{id}/edit", name="admin_comment_edit")
     *
     * @param Comment $comment
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CommentEditType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                "le commentaire a bien été modifié"
            );
            return $this->redirectToRoute('admin_user_edit',[
                'id' => $comment->getAuthor()->getId()
            ]);
        }
        return $this->render('admin/admin_comment/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * permet à l'admin d'effacer un commentaire
     * 
     * @Route("admin/comment/{id}/delete", name="admin_comment_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('admin_user_edit',[
            'id' => $comment->getAuthor()->getId()
        ]);
    }
}
