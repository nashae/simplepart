<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\SearchArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchArticleController extends AbstractController
{
    /**
     * @Route("/search/article", name="search_article")
     */
    public function index(ArticleRepository $articleRepo, Request $request)
    {
        $articles = $articleRepo->sortByDate();
        $form = $this->createForm(SearchArticleType::class);
        $search = $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $articles = $articleRepo->search($search->get('mots')->getData());
            return $this->render("search_article/result.html.twig",[
                   'articles' => $articles
           ]);
            
        }
        return $this->render('search_article/_searchbar.html.twig', [
            'article' => $articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search/result/{article}", name="search_result")
     */
    public function searchResult(Article $articles)
    {
        return $this->render('search_article/result.html.twig', [
            'article' => $articles
        ]);
    }

    /**
     * affiche la liste des articles et blogs
     * @Route("/{page<\d+>?1}", name="homepage")
     * 
     * @return Response
     */
    /*public function index1( BlogArticleRepository $blogRepo, $page, PaginatorService $paginator)
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
    */
}
