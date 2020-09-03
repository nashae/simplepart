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

    

    
    
}
