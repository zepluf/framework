<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderStatusType
 *
 * @ORM\Table(name="order_status_type")
 * @ORM\Entity
 */
class OrderStatusType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="sequence_id", type="integer", nullable=true)
     */
    private $sequenceId;



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
     * @return OrderStatusType
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
     * Set sequenceId
     *
     * @param integer $sequenceId
     * @return OrderStatusType
     */
    public function setSequenceId($sequenceId)
    {
        $this->sequenceId = $sequenceId;
    
        return $this;
    }

    /**
     * Get sequenceId
     *
     * @return integer 
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }
}