<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Users;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
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