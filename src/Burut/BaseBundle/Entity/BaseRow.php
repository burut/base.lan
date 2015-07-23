<?php

namespace Burut\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseRow
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Burut\BaseBundle\Entity\BaseRowRepository")
 */
class BaseRow
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
     * @ORM\OneToMany(targetEntity="FieldValue", mappedBy="baseRow", cascade={"persist", "remove"})
     */
    protected $fieldValues;

    public function __construct()
    {
        $this->fieldValues = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Base", inversedBy="baseRows")
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    protected $base;

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
     * Add fieldValues
     *
     * @param \Burut\BaseBundle\Entity\FieldValue $fieldValues
     * @return BaseRow
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

    /**
     * Set base
     *
     * @param \Burut\BaseBundle\Entity\Base $base
     * @return BaseRow
     */
    public function setBase(\Burut\BaseBundle\Entity\Base $base = null)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return \Burut\BaseBundle\Entity\Base 
     */
    public function getBase()
    {
        return $this->base;
    }
}
