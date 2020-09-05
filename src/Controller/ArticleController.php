<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Article;
use App\Service\PaginatorService;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    /**
     * affiche la categorie International
     * 
     * @Route("/articles/international/{page<\d+>?1}", name="index_international")
     *
     * @param PaginatorService $paginator
     * @return Response
     */
    public function indexInternational($page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                   ->setPage($page);
        
        
        return $this->render("articles/international.html.twig",[
            'paginator' => $paginator

        ]);
        
        
    }

    /**
     * page france
     * 
     * @Route("/articles/france/{page<\d+>?1}", name="index_france")
     *
     * @param PaginatorService $paginator
     * @return Response
     */
    public function indexFrance($page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                   ->setPage($page);
        
        
        return $this->render("articles/france.html.twig",[
            'paginator' => $paginator

        ]);
    }

    /**
     * page economie
     * 
     * @Route("/articles/economie/{page<\d+>?1}", name="index_economie")
     *
     * @param PaginatorService $paginator
     * @return Response
     */
    public function indexEconomie($page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                   ->setPage($page);
        
        
        return $this->render("articles/economie.html.twig",[
            'paginator' => $paginator

        ]);
    }

    /**
     * page Culture
     * 
     * @Route("/articles/culture/{page<\d+>?1}", name="index_culture")
     *
     * @param PaginatorService $paginator
     * @return Response
     */
    public function indexCulture($page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                   ->setPage($page);
        
        
        return $this->render("articles/culture.html.twig",[
            'paginator' => $paginator

        ]);
    }

    /**
     * index articles par auteur
     *
     * @route(/articles/{author}, name="index_articlesByAuthor" )
     * @param ArticleRepository $repo
     * @param Article $author
     * @return Response
     */
    /*
    public function indexAuthor(ArticleRepository $repo, Article $author)
    {
        $articles = $repo->sortByAuthor($author);
        return $this->render('articles/author.html.twig', [
            'articles' => $articles
        ])
    }
    */

    /**
     * index articles par auteur
     * 
     * @Route("/articles/{id}", name="index_articlesByAuthor")
     *
     * @param Users $users
     * @return Response
     */
    /*
    public function indexAuthor(Users $users)
    {
        return $this->render('articles/indexByAuthor.html.twig',[
            'users' => $users
        ]);
    }
    */
}