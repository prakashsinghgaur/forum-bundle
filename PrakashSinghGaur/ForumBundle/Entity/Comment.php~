<?php

namespace PrakashSinghGaur\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PrakashSinghGaur\ForumBundle\Repository\CommentRepository")
 */
class Comment
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
     *          min = 10,
     *          max = 1000,
     *           minMessage = "Please enter alteast 3 characters",
     *           maxMessage = "Maximum length 1000 characters")
     * @ORM\Column(name="description", type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Topic", inversedBy="comments")
     * @ORM\JoinColumn(name="topic_id", referencedColumnName="id")
     */
    private $topic;

    /**
     * @var datetime
     *
     * @ORM\Column(name="createdOn", type="datetime")
     */
    private $createdOn;


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
     * Set description
     *
     * @param string $description
     *
     * @return Comment
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
     * @return Comment
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
     * Set topic
     *
     * @param \PrakashSinghGaur\ForumBundle\Entity\Topic $topic
     *
     * @return Comment
     */
    public function setTopic(\PrakashSinghGaur\ForumBundle\Entity\Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \PrakashSinghGaur\ForumBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }
}
