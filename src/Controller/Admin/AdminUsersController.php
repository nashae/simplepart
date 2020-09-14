<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\AdminUserEditType;
use App\Service\PaginatorService;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUsersController extends AbstractController
{
    /**
     * affiche la liste des users
     * @Route("/admin/users/{page<\d+>?1}", name="admin_users")
     */
    public function index(PaginatorService $paginator, $page)
    {
        $paginator->setEntityClass(Users::class)
                  ->setLimit(10)
                  ->setPage($page);
        return $this->render('admin/admin_users/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * affiche le detail d'un user
     * @Route("/admin/users/{id}/edit", name="admin_user_edit")
     */
    public function edit(Users $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminUserEditType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Les données de l\'utilisateur ont bien été modifiées'
            );
            $this->redirectToRoute('admin_users');
        }
        return $this->render('admin/admin_users/edit.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * permet à l'admin de supprimer un utilisateur
     * 
     * @Route("admin/users/{id}/delete", name="admin_user_delete")
     *
     * @param Users $user
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Users $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'l\'utilisateur a bien été supprimé'
        );
        return $this->redirectToRoute('admin_users');
    }
}
