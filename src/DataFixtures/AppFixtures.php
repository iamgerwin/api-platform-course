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

    /**
     * @var Faker\Factory
     */
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_mariz');

        for ($i = 0; $i < 100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->dateTimeThisYear);
            $blogPost->setContent($this->faker->realText());
            $blogPost->setAuthor($user);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post_$i", $blogPost);
            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        $user = $this->getReference('commenter_test');

        for ($i = 0; $i < 100; $i++) {
            for ($j = 0; $j < rand(1, 10); $j++) {
                $comment = new Comment();
                $comment->setAuthor($user);
                $comment->setBlogPost($this->getReference("blog_post_$i"));
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("mariz");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password'
        ));
        $user->setEmail("mariz@gmail.com");
        $user->setName("Mariz Parayno");

        $this->addReference('user_mariz', $user);
        $manager->persist($user);

        $commenter = new User();
        $commenter->setUsername("commenter");
        $commenter->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'secret'
        ));
        $commenter->setEmail("commenter@gmail.com");
        $commenter->setName("Commenter Test");

        $this->addReference('commenter_test', $commenter);
        $manager->persist($commenter);

        $manager->flush();
    }
}
