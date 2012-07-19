<?php

/*
 * This file is part of the MGIBlogBundle package.
 *
 * Copyright 2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace MGI\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Shows blog front page
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('MGIBlogBundle:Post')
            ->findFrontpagePosts();

        return $this->render('MGIBlogBundle:Default:index.html.twig', array('posts' => $posts));
    }

    /**
     * Shows post page
     *
     * @param string $slug post slug
     */
    public function ShowAction($slug)
    {
        $post = $this->getDoctrine()
            ->getRepository('MGIBlogBundle:Post')
            ->findOneBy(array('slug' => $slug));

        if (null === $post) {
            throw $this->createNotFoundException('Post not found!');
        }

        $comments = $this->getDoctrine()
            ->getRepository('MGIBlogBundle:Comment')
            ->findPublishedComments($post);

        return $this->render('MGIBlogBundle:Default:show.html.twig', array('post' => $post, 'comments' => $comments));
    }
}

