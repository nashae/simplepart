<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\PaginatorService;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * form creation article
     *
     * @Route("articles/new", name="article_create")
     * @IsGranted("ROLE_AUTHOR")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
    $article = new Article();
    
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $article->setAuthor($this->getUser());
        $manager->persist($article);
        $manager->flush();
        $this->addFlash(
            'success',
            "l'article {$article->getTitle()} a bien été enregistré"
        );
        return $this->redirectToRoute('article_show',[
            'slug' => $article->getSlug()
        ]);
    }
    return $this->render('articles/new.html.twig', [
        'form' => $form->createView()
    ]);
    }

    /**
     * form edition article
     * 
     * @Route("articles/{slug}/edit", name="article_edit")
     * @Security("is_granted('ROLE_AUTHOR') and user == article.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     *
     * @param Article $article
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article->setAuthor($this->getUser());
            $manager->persist($article);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les modifications ont bien été enregistrées"
            );
            return $this->redirectToRoute('article_show',[
                'slug' => $article->getSlug()
            ]);
        }
        return $this->render('articles/edit.html.twig',[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }


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