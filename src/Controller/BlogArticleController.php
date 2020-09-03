<?php

namespace App\Controller;

use App\Repository\BlogArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogArticleController extends AbstractController
{
    /**
     * Index des blogs
     * 
     * @Route("blogs/index", name="blogs_index")
     *
     * @param BlogArticleRepository $repo
     * @return Response
     */
    public function index(BlogArticleRepository $repo)
    {
        $blogs = $repo->sortByDate();
        return $this->render("blogs/index.html.twig",[
            'blogs' => $blogs
        ]);
    }

}