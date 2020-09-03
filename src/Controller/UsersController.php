<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/{id}", name="users_show")
     */
    public function index(Users $users)
    {
        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }
}
