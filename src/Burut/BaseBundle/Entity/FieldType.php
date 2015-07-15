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
     * @ORM\Column(name="еtitle", type="string", length=100)
     */
    private $еtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;


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
     * Set еtitle
     *
     * @param string $еtitle
     * @return FieldType
     */
    public function setеtitle($еtitle)
    {
        $this->еtitle = $еtitle;

        return $this;
    }

    /**
     * Get еtitle
     *
     * @return string 
     */
    public function getеtitle()
    {
        return $this->еtitle;
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
}
