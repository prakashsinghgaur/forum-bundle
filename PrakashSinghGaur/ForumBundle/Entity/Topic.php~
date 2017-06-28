<?php

namespace PrakashSinghGaur\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Topic
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PrakashSinghGaur\ForumBundle\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *          min = 5,
     *          max = 450,
     *           minMessage = "Please enter alteast 5 characters",
     *           maxMessage = "Maximum length 450 characters")
     * @ORM\Column(name="title", type="string", length=450)
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *          min = 10,
     *          max = 1000,
     *           minMessage = "Please enter alteast 3 characters",
     *           maxMessage = "Maximum length 1000 characters")
     * @ORM\Column(name="description", type="string", length=1000)
     */
    private $description;


    /**
     * @var datetime
     *
     * @ORM\Column(name="createdOn", type="datetime")
     */
    private $createdOn;

    /**
     * @ORM\ManyToOne(targetEntity="Forum", inversedBy="topics")
     * @ORM\JoinColumn(name="forum_id", referencedColumnName="id")
     */
    private $forum;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="topic")
     */
    private $comments;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     *
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set description
     *
     * @param string $description
     *
     * @return Topic
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Topic
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set forum
     *
     * @param \PrakashSinghGaur\ForumBundle\Entity\Forum $forum
     *
     * @return Topic
     */
    public function setForum(\PrakashSinghGaur\ForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \PrakashSinghGaur\ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Add comment
     *
     * @param \PrakashSinghGaur\ForumBundle\Entity\Comment $comment
     *
     * @return Topic
     */
    public function addComment(\PrakashSinghGaur\ForumBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \PrakashSinghGaur\ForumBundle\Entity\Comment $comment
     */
    public function removeComment(\PrakashSinghGaur\ForumBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
