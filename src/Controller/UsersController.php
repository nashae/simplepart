<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Article;
use App\Entity\BlogArticle;
use App\Form\UserEditUserType;
use App\Service\PaginatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/articles/{id}/{page<\d+>?1}", name="users_Article_Show")
     */
    public function indexarticles(Users $users, $page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                   ->setPage($page);
        return $this->render('users/index_articles.html.twig', [
            'users' => $users,
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/users/blogs/{id}/{page<\d+>?1}", name="users_Blog_Show")
     */
    public function indexblogs(Users $users, $page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(BlogArticle::class)
                   ->setPage($page);
        return $this->render('users/index_blogs.html.twig', [
            'users' => $users,
            'paginator' => $paginator
        ]);
    }

    /**
     * permet à l'utilisateur de modifier ses informations
     * 
     * @Route("/users/edit/{id}", name="users_edit_info")
     * @IsGranted("ROLE_USER")
     *
     * @param Users $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function userEditInfo(Users $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserEditUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "Modification effectuée"
            );
            return $this->redirectToRoute("homepage");
        }
        return $this->render("users/edit_user.html.twig",[
            'form' => $form->createView()
        ]);
    }
}
