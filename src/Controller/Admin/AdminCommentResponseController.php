<?php

namespace App\Controller\Admin;

use App\Entity\CommentResponse;
use App\Form\CommentResponseEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentResponseController extends AbstractController
{
    /**
     * permet a l'admin de modifier une réponse à un commentaire
     * 
     * @Route("admin/commentresponse/{id}/edit", name="admin_commentResponse_edit")
     *
     * @param CommentResponse $comment
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(CommentResponse $commentResponse, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CommentResponseEditType::class, $commentResponse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($commentResponse);
            $manager->flush();
            $this->addFlash(
                'success',
                "cette réponse à un commentaire a bien été modifié"
            );
            return $this->redirectToRoute('admin_user_edit',[
                'id' => $commentResponse->getAuthor()->getId()
            ]);
        }
        return $this->render('admin/admin_comment_response/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * permet à l'admin d'effacer un commentaire
     * 
     * @Route("admin/commentresponse/{id}/delete", name="admin_commentResponse_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(CommentResponse $commentResponse, EntityManagerInterface $manager)
    {
        $manager->remove($commentResponse);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('admin_user_edit',[
            'id' => $commentResponse->getAuthor()->getId()
        ]);
    }
}
