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
     * @var string
     *
     * @ORM\Column(name="value", type="string", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="BaseField", inversedBy="fieldValues")
     * @ORM\JoinColumn(name="base_field_id", referencedColumnName="id")
     */
    protected $baseField;

    /**
     * @ORM\ManyToOne(targetEntity="BaseRow", inversedBy="fieldValues")
     * @ORM\JoinColumn(name="base_row_id", referencedColumnName="id")
     */
    protected $baseRow;

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

    /**
     * Set baseField
     *
     * @param \Burut\BaseBundle\Entity\BaseField $baseField
     * @return FieldValue
     */
    public function setBaseField(\Burut\BaseBundle\Entity\BaseField $baseField = null)
    {
        $this->baseField = $baseField;

        return $this;
    }

    /**
     * Get baseField
     *
     * @return \Burut\BaseBundle\Entity\BaseField 
     */
    public function getBaseField()
    {
        return $this->baseField;
    }

    /**
     * Set baseRow
     *
     * @param \Burut\BaseBundle\Entity\BaseRow $baseRow
     * @return FieldValue
     */
    public function setBaseRow(\Burut\BaseBundle\Entity\BaseRow $baseRow = null)
    {
        $this->baseRow = $baseRow;

        return $this;
    }

    /**
     * Get baseRow
     *
     * @return \Burut\BaseBundle\Entity\BaseRow 
     */
    public function getBaseRow()
    {
        return $this->baseRow;
    }
}
