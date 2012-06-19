<?php

/*
 * This file is part of the MGIBlogBundle package.
 *
 * Copyright 2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace MGI\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MGI\BlogBundle\Entity\Comment
 *
 * @ORM\Table(name="mgi_blog_comment")
 * @ORM\Entity(repositoryClass="MGI\BlogBundle\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Enter comment content")
     */
    private $content;

    /**
     * @var boolean $published
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments", fetch="EAGER")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * @Assert\Type("MGI\BlogBundle\Entity\Post")
     * @Assert\NotNull()
     */
    private $post;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set post
     *
     * @param \MGI\Blogbundle\Entity\Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * Get post
     *
     * @return \MGI\Blogbundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    public function __toString()
    {
        return $this->content;
    }

    /**
     * @ORM\prePersist
     */
    public function createCreatedAtValue()
    {
        $this->createdAt= new \DateTime();
    }
}
