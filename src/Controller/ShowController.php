<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\BlogComment;
use App\Form\CommentCreateType;
use App\Form\BlogCommentCreateType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BlogArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowController extends AbstractController

{
    /**
     * permet d'afficher un article et de poster un commentaire
     * 
     * @Route("/articles/{slug}", name="article_show")
     *
     * @param ArticleRepository $repo
     * @return Response
     */
    public function showArticle($slug, ArticleRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $article = $repo->findOneBySlug($slug);
        $Comment = new Comment;
        $form = $this->createForm(CommentCreateType::class, $Comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $Comment->setArticle($article);
            $Comment->setAuthor($this->getUser());
            $manager->persist($Comment);
            $manager->flush();
            $this->addFlash(
                'success',
                'commentaire ajouté'
            );
        }
        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * permet d'afficher un blog et de poster un commentaire
     * 
     * @Route("/blogs/{slug}", name="blog_show")
     *
     * @param blogArticleRepository $repo
     * @return Response
     */
    public function showblog($slug, blogArticleRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $blog = $repo->findOneBySlug($slug);
        $blogComment = new BlogComment;
        $form = $this->createForm(BlogCommentCreateType::class, $blogComment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $blogComment->setBlogArticle($blog);
            $blogComment->setAuthor($this->getUser());
            $manager->persist($blogComment);
            $manager->flush();
            $this->addFlash(
                'success',
                'commentaire ajouté'
            );
        }
        return $this->render('blogs/show.html.twig', [
            'blog' => $blog,
            'form' => $form->createView()
        ]);
    }
}