<?php

namespace App\Controller;

use App\Entity\BlogArticle;
use App\Form\BlogArticleType;
use App\Repository\BlogArticleRepository;
use App\Service\PaginatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogArticleController extends AbstractController
{
    /**
     * formulaire creation d'article de blog
     *
     * @Route("blogs/new", name="blogs_new")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $blogArticle = new BlogArticle();
        $form = $this->createForm(BlogArticleType::class, $blogArticle);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $blogArticle->setAuthor($this->getUser());
            $manager->persist($blogArticle);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'article de blog {{$blogArticle->getTitle()} a bien été crée"
            );
            return $this->redirectToRoute('blog_show',[
                'slug' => $blogArticle->getSlug()
            ]);
        }
        return $this->render('blogs/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * edtion d'un article de blog
     * 
     * @Route("blogs/{slug}/edit", name="blogs_edit")
     *
     * @param BlogArticle $blogArticle
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(BlogArticle $blogArticle, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(BlogArticleType::class, $blogArticle);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $blogArticle->setAuthor($this->getUser());
            $manager->persist($blogArticle);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'article de blog {{$blogArticle->getTitle()} a bien été modifé"
            );
            return $this->redirectToRoute('blog_show',[
                'slug' => $blogArticle->getSlug()
            ]);
        }
        return $this->render('blogs/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

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