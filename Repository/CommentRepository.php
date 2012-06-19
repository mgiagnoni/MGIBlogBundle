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
 * CommentRepository
 */
class CommentRepository extends EntityRepository
{
    /**
     * Finds published comments.
     *
     * @param null|Post $post if passed only comments of the given post are returned.
     *
     * @return array
     */
    public function findPublishedComments($post = null)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.published = true');

        if (null !== $post) {
            $qb->andWhere('a.post = :post');
            $qb->setParameter('post', $post);
        }

        $qb->orderBy('a.createdAt', 'desc');

        return $qb->getQuery()->getResult();
    }
}
