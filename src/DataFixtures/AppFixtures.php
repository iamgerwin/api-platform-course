<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle("A first post!");
        $blogPost->setPublished(new \DateTime('2020-07-30 12:00:00'));
        $blogPost->setContent("Content here!");
        $blogPost->setAuthor("Mariz test");
        $blogPost->setSlug("a-first-post");
        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle("Second post!");
        $blogPost->setPublished(new \DateTime('2020-07-31 12:00:00'));
        $blogPost->setContent("Second Content here!");
        $blogPost->setAuthor("Mariz test");
        $blogPost->setSlug("second-post");
        $manager->persist($blogPost);

        $manager->flush();
    }
}
