<?php

declare(strict_types=1);

namespace DH\Auditor\Tests\Provider\Doctrine\Fixtures\Entity\Standard\Blog;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity]
#[ORM\Table(name: 'author')]
class Author implements Stringable
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    protected ?string $fullname = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    protected ?string $email = null;

    #[ORM\OneToMany(targetEntity: 'Post', mappedBy: 'author', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'author_id', nullable: false)]
    protected Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getFullname() ?? self::class.'#'.$this->getId();
    }

    public function __sleep()
    {
        return ['id', 'fullname', 'email'];
    }

    /**
     * Set the value of id.
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of fullname.
     */
    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of fullname.
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * Set the value of email.
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of email.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Add Post entity to collection (one to many).
     */
    public function addPost(Post $post): self
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove Post entity from collection (one to many).
     */
    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);
        $post->setAuthor(null);

        return $this;
    }

    /**
     * Get Post entity collection (one to many).
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }
}
