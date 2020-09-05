<?php

namespace App\Controller;

use App\Entity\BlogArticle;
use App\Repository\BlogArticleRepository;
use App\Service\PaginatorService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogArticleController extends AbstractController
{
    /**
     * Index des blogs
     * 
     * @Route("blogs/index/{page<\d+>?1}", name="blogs_index")
     *
     * @param BlogArticleRepository $repo
     * @return Response
     */
    public function index(PaginatorService $paginator, $page)
    {
        $paginator->setEntityClass(BlogArticle::class)
                  ->setLimit(10)
                  ->setPage($page);
        return $this->render("blogs/index.html.twig",[
            'paginator' => $paginator
        ]);
    }

}