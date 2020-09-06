<?php

namespace App\Entity;

use App\Repository\BlogCommentResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogCommentResponseRepository::class)
 */
class BlogCommentResponse
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
     * @ORM\ManyToOne(targetEntity=BlogComment::class, inversedBy="blogCommentResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="blogCommentResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

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

    public function getComment(): ?BlogComment
    {
        return $this->comment;
    }

    public function setComment(?BlogComment $comment): self
    {
        $this->comment = $comment;

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
}
