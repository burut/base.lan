<?php

namespace Burut\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Base
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Burut\BaseBundle\Entity\BaseRepository")
 */
class Base
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
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=20)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="keyfield_id", type="integer")
     */
    private $keyfieldId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bases")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="BaseField", mappedBy="base")
     */
    protected $baseFields;

    /**
     * @ORM\OneToMany(targetEntity="BaseRow", mappedBy="base")
     */
    protected $baseRows;

    public function __construct()
    {
        $this->baseFields = new ArrayCollection();
        $this->baseRows = new ArrayCollection();
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
     * @return Base
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
     * Set color
     *
     * @param string $color
     * @return Base
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set keyfieldId
     *
     * @param integer $keyfieldId
     * @return Base
     */
    public function setKeyfieldId($keyfieldId)
    {
        $this->keyfieldId = $keyfieldId;

        return $this;
    }

    /**
     * Get keyfieldId
     *
     * @return integer
     */
    public function getKeyfieldId()
    {
        return $this->keyfieldId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Base
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \Burut\BaseBundle\Entity\User $user
     * @return Base
     */
    public function setUser(\Burut\BaseBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Burut\BaseBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add baseFields
     *
     * @param \Burut\BaseBundle\Entity\BaseField $baseFields
     * @return Base
     */
    public function addBaseField(\Burut\BaseBundle\Entity\BaseField $baseFields)
    {
        $this->baseFields[] = $baseFields;

        return $this;
    }

    /**
     * Remove baseFields
     *
     * @param \Burut\BaseBundle\Entity\BaseField $baseFields
     */
    public function removeBaseField(\Burut\BaseBundle\Entity\BaseField $baseFields)
    {
        $this->baseFields->removeElement($baseFields);
    }

    /**
     * Get baseFields
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBaseFields()
    {
        return $this->baseFields;
    }

    /**
     * Add baseRows
     *
     * @param \Burut\BaseBundle\Entity\BaseRow $baseRows
     * @return Base
     */
    public function addBaseRow(\Burut\BaseBundle\Entity\BaseRow $baseRows)
    {
        $this->baseRows[] = $baseRows;

        return $this;
    }

    /**
     * Remove baseRows
     *
     * @param \Burut\BaseBundle\Entity\BaseRow $baseRows
     */
    public function removeBaseRow(\Burut\BaseBundle\Entity\BaseRow $baseRows)
    {
        $this->baseRows->removeElement($baseRows);
    }

    /**
     * Get baseRows
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBaseRows()
    {
        return $this->baseRows;
    }
}
