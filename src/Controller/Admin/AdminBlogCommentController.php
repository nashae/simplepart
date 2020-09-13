<?php

namespace App\Controller\Admin;

use App\Entity\BlogComment;
use App\Form\BlogCommentEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBlogCommentController extends AbstractController
{
    /**
     * permet a l'admin de modifier un commentaire de blog
     * 
     * @Route("admin/blogcomment/{id}/edit", name="admin_blogComment_edit")
     *
     * @param BlogComment $blogComment
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(BlogComment $blogComment, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(BlogCommentEditType::class, $blogComment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($blogComment);
            $manager->flush();
            $this->addFlash(
                'success',
                "le commentaire a bien été modifié"
            );
            return $this->redirectToRoute('admin_user_edit',[
                'id' => $blogComment->getAuthor()->getId()
            ]);
        }
        return $this->render('admin/admin_comment/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * permet à l'admin d'effacer un commentaire de blog
     * 
     * @Route("admin/blogcomment/{id}/delete", name="admin_blogComment_delete")
     * @Security("is_granted('ROLE_USER') and user == blogComment.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     *
     * @param BlogComment $blogComment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(BlogComment $blogComment, EntityManagerInterface $manager)
    {
        $manager->remove($blogComment);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('admin_user_edit',[
            'id' => $blogComment->getAuthor()->getId()
        ]);
    }
}

