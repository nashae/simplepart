<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\BlogArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowController extends AbstractController

{
    /**
     * permet d'afficher un article
     * 
     * @Route("/articles/{slug}", name="article_show")
     *
     * @param ArticleRepository $repo
     * @return Response
     */
    public function showArticle($slug, ArticleRepository $repo)
    {
        $article = $repo->findOneBySlug($slug);
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * permet d'afficher un blog
     * 
     * @Route("/blogs/{slug}", name="blog_show")
     *
     * @param blogArticleRepository $repo
     * @return Response
     */
    public function showblog($slug, blogArticleRepository $repo)
    {
        $blog = $repo->findOneBySlug($slug);
        return $this->render('blogs/show.html.twig', [
            'blog' => $blog
        ]);
    }
}