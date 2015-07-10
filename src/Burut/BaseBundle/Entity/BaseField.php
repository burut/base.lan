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
     * @var integer
     *
     * @ORM\Column(name="base_id", type="integer")
     */
    private $baseId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_id", type="integer")
     */
    private $typeId;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="string", length=100)
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set baseId
     *
     * @param integer $baseId
     * @return BaseField
     */
    public function setBaseId($baseId)
    {
        $this->baseId = $baseId;

        return $this;
    }

    /**
     * Get baseId
     *
     * @return integer 
     */
    public function getBaseId()
    {
        return $this->baseId;
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
     * Set typeId
     *
     * @param integer $typeId
     * @return BaseField
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->typeId;
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
}
