<?php

/*
 * This file is part of the MGIBlogBundle package.
 *
 * Copyright 2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace MGI\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 */
class PostRepository extends EntityRepository
{
    /**
     * Finds posts to be shown on blog front page.
     *
     * @return array
     */
    public function findFrontpagePosts()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->orderBy('a.createdAt', 'desc');

        return $qb->getQuery()->getResult();
    }
}
