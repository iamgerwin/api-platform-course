<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadComments($manager);
        $this->loadBlogPosts($manager);
    }
    
    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_mariz');
        
        $blogPost = new BlogPost();
        $blogPost->setTitle("A first post!");
        $blogPost->setPublished(new \DateTime('2020-07-30 12:00:00'));
        $blogPost->setContent("Content here!");
        $blogPost->setAuthor($user);
        $blogPost->setSlug("a-first-post");
        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle("Second post!");
        $blogPost->setPublished(new \DateTime('2020-07-31 12:00:00'));
        $blogPost->setContent("Second Content here!");
        $blogPost->setAuthor($user);
        $blogPost->setSlug("second-post");
        $manager->persist($blogPost);

        $manager->flush();
    }
    
    public function loadComments(ObjectManager $manager)
    {
        $user = $this->getReference('commenter_test');
        
        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setContent("This is a comment.");
        $comment->setPublished(new \DateTime('now'));
        
        $manager->persist($comment);
        $manager->flush();
    }
    
    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("mariz");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'password'
        ));
        $user->setEmail("mariz@gmail.com");
        $user->setName("Mariz Parayno");
        
        $this->addReference('user_mariz', $user);
        $manager->persist($user);
        
        $commenter = new User();
        $commenter->setUsername("commenter");
        $commenter->setPassword($this->passwordEncoder->encodePassword(
            $user, 'secret'));
        $commenter->setEmail("commenter@gmail.com");
        $commenter->setName("Commenter Test");
        
        $this->addReference('commenter_test', $commenter);
        $manager->persist($commenter);
        
        $manager->flush();
    }
}
