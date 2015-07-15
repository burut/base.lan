<?php

namespace Burut\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldValue
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Burut\BaseBundle\Entity\FieldValueRepository")
 */
class FieldValue
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
     * @ORM\Column(name="base_record_id", type="integer")
     */
    private $baseRecordId;

    /**
     * @var integer
     *
     * @ORM\Column(name="base_field_id", type="integer")
     */
    private $baseFieldId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=100)
     */
    private $value;


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
     * Set baseRecordId
     *
     * @param integer $baseRecordId
     * @return FieldValue
     */
    public function setBaseRecordId($baseRecordId)
    {
        $this->baseRecordId = $baseRecordId;

        return $this;
    }

    /**
     * Get baseRecordId
     *
     * @return integer 
     */
    public function getBaseRecordId()
    {
        return $this->baseRecordId;
    }

    /**
     * Set baseFieldId
     *
     * @param integer $baseFieldId
     * @return FieldValue
     */
    public function setBaseFieldId($baseFieldId)
    {
        $this->baseFieldId = $baseFieldId;

        return $this;
    }

    /**
     * Get baseFieldId
     *
     * @return integer 
     */
    public function getBaseFieldId()
    {
        return $this->baseFieldId;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return FieldValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
}
