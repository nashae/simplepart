<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Article;
use App\Service\PaginatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/{id}/{page<\d+>?1}", name="users_show")
     */
    public function index(Users $users, $page, PaginatorService $paginator)
    {
        $paginator->setEntityClass(Article::class)
                   ->setPage($page);
        return $this->render('users/index.html.twig', [
            'users' => $users,
            'paginator' => $paginator
        ]);
    }
}
