<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\BlogArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * affiche la liste des articles et blogs
     * @Route("/", name="homepage")
     */
    public function index(ArticleRepository $articleRepo, BlogArticleRepository $blogRepo)
    {
        $articles = $articleRepo->findAll();
        $blogs = $blogRepo->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'blogs' => $blogs
        ]);
    }
}
