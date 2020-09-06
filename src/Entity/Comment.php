<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=CommentResponse::class, mappedBy="Comment", orphanRemoval=true)
     */
    private $commentResponses;

    public function __construct()
    {
        $this->commentResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    public function setAuthor(?Users $author): self
    {
        $this->author = $author;

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
            $commentResponse->setComment($this);
        }

        return $this;
    }

    public function removeCommentResponse(CommentResponse $commentResponse): self
    {
        if ($this->commentResponses->contains($commentResponse)) {
            $this->commentResponses->removeElement($commentResponse);
            // set the owning side to null (unless already changed)
            if ($commentResponse->getComment() === $this) {
                $commentResponse->setComment(null);
            }
        }

        return $this;
    }
}
