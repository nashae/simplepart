<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\OneToMany(targetEntity=BlogArticle::class, mappedBy="author", orphanRemoval=true)
     */
    private $blogArticles;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author", orphanRemoval=true)
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=CommentResponse::class, mappedBy="author", orphanRemoval=true)
     */
    private $commentResponses;

    /**
     * @ORM\OneToMany(targetEntity=BlogComment::class, mappedBy="author", orphanRemoval=true)
     */
    private $blogComments;

    /**
     * @ORM\OneToMany(targetEntity=BlogCommentResponse::class, mappedBy="author", orphanRemoval=true)
     */
    private $blogCommentResponses;

    public function __construct()
    {
        $this->blogArticles = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->commentResponses = new ArrayCollection();
        $this->blogComments = new ArrayCollection();
        $this->blogCommentResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->userName;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return Collection|BlogArticle[]
     */
    public function getBlogArticles(): Collection
    {
        return $this->blogArticles;
    }

    public function addBlogArticle(BlogArticle $blogArticle): self
    {
        if (!$this->blogArticles->contains($blogArticle)) {
            $this->blogArticles[] = $blogArticle;
            $blogArticle->setAuthor($this);
        }

        return $this;
    }

    public function removeBlogArticle(BlogArticle $blogArticle): self
    {
        if ($this->blogArticles->contains($blogArticle)) {
            $this->blogArticles->removeElement($blogArticle);
            // set the owning side to null (unless already changed)
            if ($blogArticle->getAuthor() === $this) {
                $blogArticle->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentResponse[]
     */
    public function getCommentResponses(): Collection
    {
        return $this->commentResponses;
    }

    public function addCommentResponse(CommentResponse $commentResponse): self
    {
        if (!$this->commentResponses->contains($commentResponse)) {
            $this->commentResponses[] = $commentResponse;
            $commentResponse->setAuthor($this);
        }

        return $this;
    }

    public function removeCommentResponse(CommentResponse $commentResponse): self
    {
        if ($this->commentResponses->contains($commentResponse)) {
            $this->commentResponses->removeElement($commentResponse);
            // set the owning side to null (unless already changed)
            if ($commentResponse->getAuthor() === $this) {
                $commentResponse->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogComment[]
     */
    public function getBlogComments(): Collection
    {
        return $this->blogComments;
    }

    public function addBlogComment(BlogComment $blogComment): self
    {
        if (!$this->blogComments->contains($blogComment)) {
            $this->blogComments[] = $blogComment;
            $blogComment->setAuthor($this);
        }

        return $this;
    }

    public function removeBlogComment(BlogComment $blogComment): self
    {
        if ($this->blogComments->contains($blogComment)) {
            $this->blogComments->removeElement($blogComment);
            // set the owning side to null (unless already changed)
            if ($blogComment->getAuthor() === $this) {
                $blogComment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogCommentResponse[]
     */
    public function getBlogCommentResponses(): Collection
    {
        return $this->blogCommentResponses;
    }

    public function addBlogCommentResponse(BlogCommentResponse $blogCommentResponse): self
    {
        if (!$this->blogCommentResponses->contains($blogCommentResponse)) {
            $this->blogCommentResponses[] = $blogCommentResponse;
            $blogCommentResponse->setAuthor($this);
        }

        return $this;
    }

    public function removeBlogCommentResponse(BlogCommentResponse $blogCommentResponse): self
    {
        if ($this->blogCommentResponses->contains($blogCommentResponse)) {
            $this->blogCommentResponses->removeElement($blogCommentResponse);
            // set the owning side to null (unless already changed)
            if ($blogCommentResponse->getAuthor() === $this) {
                $blogCommentResponse->setAuthor(null);
            }
        }

        return $this;
    }

    
}
