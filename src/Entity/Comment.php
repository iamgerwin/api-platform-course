<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;
    
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
    * @ORM\JoinColumn(nullable=false)
    */
    private $author;
    
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="comments")
    * @ORM\JoinColumn(nullable=false)
    */
    private $blogPost;
    
    public function __construct()
    {

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

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }
    
    /**
     * @return User
     */
    function getAuthor(): User
    { 
        return $this->author; 
    } 

    /**
     * @param User $author
     */
    function setAuthor(User $author): self
    {  
        $this->author = $author;
        
        return $this;
    }
    
    /**
     * @return BlogPost
     */
    function getBlogPost(): BlogPost
    { 
        return $this->blogPost; 
    } 

    /**
     * @param BlogPost $blogPost
     */
    function setBlogPost(BlogPost $blogPost): self
    {  
        $this->blogPost = $blogPost;
        
        return $this;
    }
}
