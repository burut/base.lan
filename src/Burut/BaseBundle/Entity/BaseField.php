<?php

namespace Burut\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseField
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Burut\BaseBundle\Entity\BaseFieldRepository")
 */
class BaseField
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
     * @ORM\Column(name="config", type="text", nullable=true)
     */
    private $config;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_show", type="boolean")
     */
    private $isShow;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_requiered", type="boolean")
     */
    private $isRequiered;


    /**
     * @ORM\ManyToOne(targetEntity="base", inversedBy="baseFields")
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    protected $base;

    /**
     * @ORM\ManyToOne(targetEntity="FieldType", inversedBy="baseFields")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $fieldType;

    /**
     * @ORM\OneToMany(targetEntity="FieldValue", mappedBy="baseField")
     */
    protected $fieldValues;

    public function __construct()
    {
        $this->fieldValues = new ArrayCollection();
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
     * @return BaseField
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
     * Set config
     *
     * @param string $config
     * @return BaseField
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return string 
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set isShow
     *
     * @param boolean $isShow
     * @return BaseField
     */
    public function setIsShow($isShow)
    {
        $this->isShow = $isShow;

        return $this;
    }

    /**
     * Get isShow
     *
     * @return boolean 
     */
    public function getIsShow()
    {
        return $this->isShow;
    }

    /**
     * Set isRequiered
     *
     * @param boolean $isRequiered
     * @return BaseField
     */
    public function setIsRequiered($isRequiered)
    {
        $this->isRequiered = $isRequiered;

        return $this;
    }

    /**
     * Get isRequiered
     *
     * @return boolean 
     */
    public function getIsRequiered()
    {
        return $this->isRequiered;
    }

    /**
     * Set base
     *
     * @param \Burut\BaseBundle\Entity\base $base
     * @return BaseField
     */
    public function setBase(\Burut\BaseBundle\Entity\base $base = null)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return \Burut\BaseBundle\Entity\base 
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set fieldType
     *
     * @param \Burut\BaseBundle\Entity\FieldType $fieldType
     * @return BaseField
     */
    public function setFieldType(\Burut\BaseBundle\Entity\FieldType $fieldType = null)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Get fieldType
     *
     * @return \Burut\BaseBundle\Entity\FieldType 
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Add fieldValues
     *
     * @param \Burut\BaseBundle\Entity\FieldValue $fieldValues
     * @return BaseField
     */
    public function addFieldValue(\Burut\BaseBundle\Entity\FieldValue $fieldValues)
    {
        $this->fieldValues[] = $fieldValues;

        return $this;
    }

    /**
     * Remove fieldValues
     *
     * @param \Burut\BaseBundle\Entity\FieldValue $fieldValues
     */
    public function removeFieldValue(\Burut\BaseBundle\Entity\FieldValue $fieldValues)
    {
        $this->fieldValues->removeElement($fieldValues);
    }

    /**
     * Get fieldValues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFieldValues()
    {
        return $this->fieldValues;
    }
}
