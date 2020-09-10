<?php

namespace App\Controller\Admin;

use App\Entity\BlogArticle;
use App\Form\BlogArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBlogArticleController extends AbstractController
{
    /**
     * permet à l'admin de modifier un article
     * 
     * @Route("admin/blogarticle/{slug}/edit", name="admin_blogArticle_edit")
     *
     * @param BlogArticle $blogArticle
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(BlogArticle $blogArticle, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(BlogArticleType::class, $blogArticle);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           
            $manager->persist($blogArticle);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'article de blog <strong>{$blogArticle->getTitle()}</strong> a bien été modifé"
            );
            return $this->redirectToRoute('admin_user_edit',[
                'id' => $blogArticle->getAuthor()->getId()
            ]);
        }
        return $this->render('admin/admin_blog_article/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * permet à l'admin de supprimer un article de blog
     * 
     * @Route("admin/blogarticle/{slug}/delete", name="admin_blogArticle_delete")
     *
     * @param BlogArticle $blogArticle
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(BlogArticle $blogArticle, EntityManagerInterface $manager)
    {
        $manager->remove($blogArticle);
        $manager->flush();
        $this->addFlash(
            'success', 
            "L'annonce a bien été supprimée"
        );
        return $this->redirectToRoute('admin_user_edit',[
            'id' => $blogArticle->getAuthor()->getId()
        ]);
    }
}


