<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Comment;
use App\Entity\BlogArticle;
use App\Entity\BlogComment;
use App\Entity\CommentResponse;
use App\Form\CommentResponseType;
use App\Entity\BlogCommentResponse;
use App\Form\BlogCommentCreateType;
use App\Form\BlogCommentResponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * permet de repondre à un commentaire d'article'
     * 
     * @Route("/CommentResponse/{comment}/create", name="CommentResponse_create")
     * @IsGranted("ROLE_USER")
     *
     * @param Comment $comment
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Reponse
     */
    public function CommentResponseCreate(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $commentResponse = new CommentResponse;
        $form = $this->createForm(CommentResponseType::class, $commentResponse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $commentResponse->setComment($comment);
            $commentResponse->setAuthor($this->getUser());
            $manager->persist($commentResponse);
            $manager->flush();
            return $this->redirectToRoute('article_show',[
                'slug' => $comment->getArticle()->getSlug()
            ]);
        }
        return $this->render("comment/comment_response.html.twig",[
            'form' => $form->createView()
            
        ]);
    }

    /**
     * permet de repondre à un commentaire de blog
     * 
     * @Route("/blogcommentResponse/{blogComment}/create", name="blogCommentResponse_create")
     * @IsGranted("ROLE_USER")
     *
     * @param BlogArticle $blogArticle
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function blogCommentResponseCreate(BlogComment $blogComment, Request $request, EntityManagerInterface $manager)
    {
        $blogCommentResponse = new BlogCommentResponse;
        $form = $this->createForm(BlogCommentResponseType::class, $blogCommentResponse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $blogCommentResponse->setComment($blogComment);
            $blogCommentResponse->setAuthor($this->getUser());
            $manager->persist($blogCommentResponse);
            $manager->flush();
            return $this->redirectToRoute('blog_show',[
                'slug' => $blogComment->getBlogArticle()->getSlug()
            ]);
        }
        return $this->render("comment/blog_comment_response.html.twig",[
            'form' => $form->createView()
            
        ]);
    }

    /**
     * permet d'afficher la liste des commentaires blogcomment et responses d'un utilisateur
     * 
     * @Route("commentlist/{user}", name="commentByUserList")
     * @IsGranted("ROLE_USER")
     *
     * @param Users $user
     * @return void
     */
    public function showCommentByUser(Users $user)
    {
        return $this->render("comment/comment_by_user.html.twig",[
            'user' => $user
        ]);
    }

    /**
     * permet à l'user d'effacer un commentaire
     * 
     * @Route("comment/{id}/delete", name="comment_delete")
     * @Security("is_granted('ROLE_USER') and user == comment.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")

     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('commentByUserList',[
            'user' => $comment->getAuthor()->getId()
        ]);
    }

    /**
     * permet à l'user d'effacer une reponse à un commentaire
     * 
     * @Route("commentresponse/{id}/delete", name="commentResponse_delete")
     * 
     * @Security("is_granted('ROLE_USER') and user == commentResponse.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function deleteCommentResponse(CommentResponse $commentResponse, EntityManagerInterface $manager)
    {
        $manager->remove($commentResponse);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('commentByUserList',[
            'user' => $commentResponse->getAuthor()->getId()
        ]);
    }

    /**
     * permet à l'utilisateur d'effacer un commentaire de blog
     * 
     * @Route("blogcomment/{id}/delete", name="blogComment_delete")
     * @Security("is_granted('ROLE_USER') and user == blogComment.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     *
     * @param BlogComment $blogComment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function deleteBlogComment(BlogComment $blogComment, EntityManagerInterface $manager)
    {
        $manager->remove($blogComment);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('commentByUserList',[
            'user' => $blogComment->getAuthor()->getId()
        ]);
    }

     /**
     * permet à l'user d'effacer une réponse à un commentaire de blog
     * 
     * @Route("blogcommentresponse/{id}/delete", name="blogCommentResponse_delete")
     * @Security("is_granted('ROLE_USER') and user == blogCommentResponse.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     *
     * @param BlogCommentResponse $blogCommentResponse
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function deleteBlogCommentResponse(BlogCommentResponse $blogCommentResponse, EntityManagerInterface $manager)
    {
        $manager->remove($blogCommentResponse);
        $manager->flush();
        $this->addFlash(
            'success', 
            "Le commentaire a bien été supprimée"
        );
        return $this->redirectToRoute('commentByUserList',[
            'user' => $blogCommentResponse->getAuthor()->getId()
        ]);
    }
}
