<?php

namespace App\Entity;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BlogArticleRepository;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BlogArticleRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"title"},
 *  message="Un article de blog possède déjà ce titre, merci de le modifier"
 * )
 */
class BlogArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Le titre doit faire plus de 3 caractères")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="blogArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=BlogComment::class, mappedBy="BlogArticle", orphanRemoval=true)
     */
    private $blogComments;

    public function __construct()
    {
        $this->blogComments = new ArrayCollection();
    }

    
    /**
     * creation du slug
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function InitializeSlug()
    {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }

    /**
     * creation du createdAT
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeCreatedAt()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
            $blogComment->setBlogArticle($this);
        }

        return $this;
    }

    public function removeBlogComment(BlogComment $blogComment): self
    {
        if ($this->blogComments->contains($blogComment)) {
            $this->blogComments->removeElement($blogComment);
            // set the owning side to null (unless already changed)
            if ($blogComment->getBlogArticle() === $this) {
                $blogComment->setBlogArticle(null);
            }
        }

        return $this;
    }

 


    
}
