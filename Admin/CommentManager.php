<?php

/*
 * This file is part of the MGIBlogBundle package.
 *
 * Copyright 2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace MGI\BlogBundle\Admin;

use Lyra\AdminBundle\Model\ORM\ModelManager as BaseManager;

class CommentManager extends BaseManager
{
    public function getBaseListQueryBuilder()
    {
        $qb = parent::getBaseListQueryBuilder();
        $qb->select('a');
        $qb->leftJoin('a.post', 'post');

        return $qb;
    }
}

