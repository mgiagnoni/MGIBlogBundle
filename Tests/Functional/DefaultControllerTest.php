<?php

/*
 * This file is part of the MGIBlogBundle package.
 *
 * Copyright 2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace MGI\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use MGI\BlogBundle\Entity\Post;
use MGI\BlogBundle\Entity\Comment;

class DefaultControllerTest extends WebTestCase
{
    private $container;

    /**
     * Blog front page test
     */
    public function testIndex()
    {
        $this->createTestData();
        $client = static::createClient();

        // Posts are ordered by date (most recent first)
        $crawler = $client->request('GET', '/');
        $titles = $crawler->filter('h2.post-title')->extract('_text');
        $this->assertEquals(
            array('without summary','with summary'),
            $titles
        );

        // Only post summary is shown in front page
        $this->assertTrue($crawler->filter('body:contains("not-in-front-page")')->count() == 0);
    }

    /**
     * Post page test
     */
    public function testShowAction()
    {
        $this->createTestData();
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // First post: without summary, with comments
        $link = $crawler->filter('a:contains("Read more")')->eq(0)->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('body:contains("test-content")')->count() > 0);
        $this->assertTrue($crawler->filter('body:contains("published-comment")')->count() > 0);
        // Unpublished comment not shown
        $this->assertTrue($crawler->filter('body:contains("not-published-comment")')->count() == 0);

        $crawler = $client->back();

        // Second post: with summary, without comments
        $link = $crawler->filter('a:contains("Read more")')->eq(1)->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('body:contains("post-summary")')->count() > 0);
        $this->assertTrue($crawler->filter('body:contains("not-in-front-page")')->count() > 0);
        $this->assertTrue($crawler->filter('body:contains("There are no comments")')->count() > 0);
    }

    protected function setup()
    {
        $client = static::createClient();
        $this->container = $client->getContainer();
        $em = $this->container->get('doctrine')->getEntityManager();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $schemaTool->dropDatabase();
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }
    }

    private function createTestData()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $p1 = new Post();
        $p1->setTitle('without summary');
        $p1->setContent('test-content');
        $c1 = new Comment();
        $c1->setContent('published-comment');
        $c1->setPublished(true);
        $c1->setPost($p1);
        $em->persist($c1);
        $c2 = new Comment();
        $c2->setContent('not-published-comment');
        $c2->setPublished(false);
        $c2->setPost($p1);
        $em->persist($c2);
        $em->persist($p1);

        $p2 = new Post();
        $p2->setTitle('with summary');
        $p2->setContent('post-summary<!--more-->not-in-front-page');
        $p2->setCreatedAt(new \DateTime('-1 hour'));
        $em->persist($p2);

        $em->flush();
    }
}
