<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\BlogArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * affiche la liste des articles et blogs
     * @Route("/", name="homepage")
     */
    public function index(ArticleRepository $articleRepo, BlogArticleRepository $blogRepo)
    {
        $articles = $articleRepo->sortByDate();
        $blogs = $blogRepo->sortByDate();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'blogs' => $blogs
        ]);
    }

    /**
     * affiche la categorie International
     * 
     * @Route("/articles/international", name="index_international")
     *
     * @param ArticleRepository $articleRepo
     * @return Response
     */
    public function indexInternational(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->sortByCategory('international');
        return $this->render("articles/international.html.twig",[
            'articles' => $articles
        ]);
        
        
    }

    /**
     * page france
     * 
     * @Route("/articles/france", name="index_france")
     *
     * @param ArticleRepository $articleRepo
     * @return Response
     */
    public function indexFrance(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->sortByCategory('france');
        return $this->render('articles/france.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * page economie
     * 
     * @Route("/articles/economie", name="index_economie")
     *
     * @param ArticleRepository $articleRepo
     * @return Response
     */
    public function indexEconomie(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->sortByCategory('economie');
        return $this->render('articles/economie.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * page Culture
     * 
     * @Route("/articles/culture", name="index_culture")
     *
     * @param ArticleRepository $articleRepo
     * @return Response
     */
    public function indexCulture(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->sortByCategory('culture');
        return $this->render('articles/culture.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * permet d'afficher un article
     * 
     * @Route("/articles/{slug}", name="article_show")
     *
     * @param Article $article
     * @return Response
     */
    public function showArticle($slug, ArticleRepository $repo)
    {
        $article = $repo->findOneBySlug($slug);
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }
    
}
