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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Lyra\AdminBundle\Controller\AdminController;

/**
 * Extends base LyraAdminBundle controller to manage comment custom actions
 */
class AdminCommentController extends AdminController
{
    /**
     * Lists comments of a given post.
     *
     * @param integer $post_id post id
     */
    public function commentsAction($id)
    {
        // We need the 'post' model manager while we are in 'comment' controller
        // we pass the model name to getModelManager()
        $post = $this->getModelManager('post')->find($id);
        if (null === $post) {
            throw new NotFoundHttpException('Post not found!');
        }

        // Sets a filter criteria to populate the list with all comments of this post
        $filter = $this->getFilter();
        $filter->setCriteria(array('post' => $post));

        // The default index action performs the rest of the work
        return parent::indexAction();
    }

    /**
     * Creates a new comment.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $this->getSecurityManager()->allowOr403('new');

        $object = $this->getModelManager()->create();

        $criteria = $this->getFilter()->getCriteria();
        // If the comment list is filtered by post ...
        if (isset($criteria['post'])) {
            // ... a new comment is added by default to that post
            $object->setPost($criteria['post']);
        }

        $form = $this->getForm($object);

        if ($form->handleRequest($this->getRequest())) {
            $this->getModelManager()->save($object);

            return $this->getRedirectToListResponse();
        }

        return $this->getRenderFormResponse($form);
    }
}
