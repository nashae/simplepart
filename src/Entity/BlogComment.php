<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BlogCommentResponse;
use App\Repository\BlogCommentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=BlogCommentRepository::class)
 */
class BlogComment
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
     * @ORM\ManyToOne(targetEntity=BlogArticle::class, inversedBy="blogComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $BlogArticle;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="blogComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=BlogCommentResponse::class, mappedBy="comment", orphanRemoval=true)
     */
    private $blogCommentResponses;

    public function __construct()
    {
        $this->blogCommentResponses = new ArrayCollection();
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

    public function getBlogArticle(): ?BlogArticle
    {
        return $this->BlogArticle;
    }

    public function setBlogArticle(?BlogArticle $BlogArticle): self
    {
        $this->BlogArticle = $BlogArticle;

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
            $blogCommentResponse->setComment($this);
        }

        return $this;
    }

    public function removeBlogCommentResponse(BlogCommentResponse $blogCommentResponse): self
    {
        if ($this->blogCommentResponses->contains($blogCommentResponse)) {
            $this->blogCommentResponses->removeElement($blogCommentResponse);
            // set the owning side to null (unless already changed)
            if ($blogCommentResponse->getComment() === $this) {
                $blogCommentResponse->setComment(null);
            }
        }

        return $this;
    }
}
