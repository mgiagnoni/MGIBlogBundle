<?php

/*
 * This file is part of the MGIBlogBundle package.
 *
 * Copyright 2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace MGI\BlogBundle\Tests;

use MGI\BlogBundle\Entity\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSummary()
    {
        $post = new Post();
        $post->setContent('content');

        $this->assertEquals('content', $post->getSummary());

        $post->setContent('summary<!--more-->content');

        $this->assertEquals('summary', $post->getSummary());
    }
}

