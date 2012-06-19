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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MGI\BlogBundle\Entity\Post
 *
 * @ORM\Table(name="mgi_blog_post")
 * @ORM\Entity(repositoryClass="MGI\BlogBundle\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message = "Enter post title")
     */
    private $title;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message = "Enter post content")
     */
    private $content;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $comments
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", orphanRemoval="true", cascade={"all"})
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
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
     * Get comments
     *
     * @return  \Doctrine\Common\Collections\ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get post summary.
     *
     * <!--more--> can be inserted in post to separate content and summary.
     *
     * @return string
     */
    public function getSummary()
    {
        $content = $this->getContent();
        $p = strpos($content, '<!--more-->');

        return false !== $p ? substr($content, 0, $p) : $content;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @ORM\prePersist
     */
    public function createCreatedAtValue()
    {
        if (null === $this->createdAt) {
            $this->createdAt= new \DateTime();
        }
    }
}
