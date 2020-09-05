<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\PaginatorService;
use App\Repository\BlogArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * affiche la liste des articles et blogs
     * @Route("/{page<\d+>?1}", name="homepage")
     * 
     * @return Response
     */
    public function index( BlogArticleRepository $blogRepo, $page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                  ->setPage($page);
        
        
        //$articles = $articleRepo->sortByDate();
        $blogs = $blogRepo->sortByDate();
        return $this->render('home/index.html.twig', [
            'blogs' => $blogs,
            'paginator' => $paginator
        ]);
    }

    

    
    
}
