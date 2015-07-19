<?php

namespace Burut\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Burut\BaseBundle\Entity\FieldTypeRepository")
 */
class FieldType
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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="BaseField", mappedBy="fieldType")
     */
    protected $baseFields;

    public function __construct()
    {
        $this->baseFields = new ArrayCollection();
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
     * @return FieldType
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
     * Set code
     *
     * @param string $code
     * @return FieldType
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add baseFields
     *
     * @param \Burut\BaseBundle\Entity\BaseField $baseFields
     * @return FieldType
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
}
