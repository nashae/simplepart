<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArticleController extends AbstractController
{
   
     /**
     * form edition article par admin
     * 
     * @Route("admin/articles/{slug}/edit", name="admin_article_edit")
     *
     * @param Article $article
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article->setAuthor($this->getUser());
            $manager->persist($article);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les modifications ont bien été enregistrées"
            );
            return $this->redirectToRoute('admin_user_edit',[
                'id' => $article->getAuthor()->getId()
            ]);
        }
        return $this->render('admin/admin_article/edit.html.twig',[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * permet de supprimer un article
     * 
     * @Route("admin/articles/{slug}/delete", name="admin_article_delete")
     *
     * @param Article $article
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();
        $this->addFlash(
            'success', 
            "L'annonce a bien été supprimée"
        );
        return $this->redirectToRoute('admin_user_edit',[
            'id' => $article->getAuthor()->getId()
        ]);
    }
}
