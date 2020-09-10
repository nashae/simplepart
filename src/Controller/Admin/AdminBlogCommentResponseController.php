<?php

namespace App\Controller\Admin;

use App\Entity\BlogCommentResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\BlogCommentResponseEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBlogCommentResponseController extends AbstractController
{
    /**
     * permet a l'admin de modifier une réponse à un commentaire de blog
     * 
     * @Route("admin/blogcommentresponse/{id}/edit", name="admin_blogCommentResponse_edit")
     *
     * @param BlogCommentResponse $blogCommentResponse
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(BlogCommentResponse $blogCommentResponse, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(BlogCommentResponseEditType::class, $blogCommentResponse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($blogCommentResponse);
            $manager->flush();
            $this->addFlash(
                'success',
                "la réponse au commentaire a bien été modifié"
            );
            return $this->redirectToRoute('admin_user_edit',[
                'id' => $blogCommentResponse->getAuthor()->getId()
            ]);
        }
        return $this->render('admin/admin_blog_comment_response/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * permet à l'admin d'effacer une réponse à un commentaire de blog
     * 
     * @Route("admin/blogcommentresponse/{id}/delete", name="admin_blogCommentResponse_delete")
     *
     * @param BlogCommentResponse $blogCommentResponse
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(BlogCommentResponse $blogCommentResponse, EntityManagerInterface $manager)
    {
        $manager->remove($blogCommentResponse);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('admin_user_edit',[
            'id' => $blogCommentResponse->getAuthor()->getId()
        ]);
    }
}


