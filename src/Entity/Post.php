<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $postedAt;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="post")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     */
    private $likedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class, inversedBy="post")
     */
    private $comment;

    public function __construct()
    {
        $this->author = new ArrayCollection();
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

    public function getPostedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeImmutable $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(User $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author[] = $author;
            $author->setPost($this);
        }

        return $this;
    }

    public function removeAuthor(User $author): self
    {
        if ($this->author->removeElement($author)) {
            // set the owning side to null (unless already changed)
            if ($author->getPost() === $this) {
                $author->setPost(null);
            }
        }

        return $this;
    }

    public function getLikedBy(): ?User
    {
        return $this->likedBy;
    }

    public function setLikedBy(?User $likedBy): self
    {
        $this->likedBy = $likedBy;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
