<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity
 */
class Person
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
     * @ORM\Column(name="current_last_name", type="string", length=255, nullable=true)
     */
    private $currentLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="current_first_name", type="string", length=255, nullable=true)
     */
    private $currentFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="current_middle_name", type="string", length=255, nullable=true)
     */
    private $currentMiddleName;

    /**
     * @var string
     *
     * @ORM\Column(name="current_personal_title", type="string", length=255, nullable=true)
     */
    private $currentPersonalTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="current_suffix", type="string", length=255, nullable=true)
     */
    private $currentSuffix;

    /**
     * @var string
     *
     * @ORM\Column(name="current_nickname", type="string", length=255, nullable=true)
     */
    private $currentNickname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=45, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;



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
     * Set currentLastName
     *
     * @param string $currentLastName
     * @return Person
     */
    public function setCurrentLastName($currentLastName)
    {
        $this->currentLastName = $currentLastName;
    
        return $this;
    }

    /**
     * Get currentLastName
     *
     * @return string 
     */
    public function getCurrentLastName()
    {
        return $this->currentLastName;
    }

    /**
     * Set currentFirstName
     *
     * @param string $currentFirstName
     * @return Person
     */
    public function setCurrentFirstName($currentFirstName)
    {
        $this->currentFirstName = $currentFirstName;
    
        return $this;
    }

    /**
     * Get currentFirstName
     *
     * @return string 
     */
    public function getCurrentFirstName()
    {
        return $this->currentFirstName;
    }

    /**
     * Set currentMiddleName
     *
     * @param string $currentMiddleName
     * @return Person
     */
    public function setCurrentMiddleName($currentMiddleName)
    {
        $this->currentMiddleName = $currentMiddleName;
    
        return $this;
    }

    /**
     * Get currentMiddleName
     *
     * @return string 
     */
    public function getCurrentMiddleName()
    {
        return $this->currentMiddleName;
    }

    /**
     * Set currentPersonalTitle
     *
     * @param string $currentPersonalTitle
     * @return Person
     */
    public function setCurrentPersonalTitle($currentPersonalTitle)
    {
        $this->currentPersonalTitle = $currentPersonalTitle;
    
        return $this;
    }

    /**
     * Get currentPersonalTitle
     *
     * @return string 
     */
    public function getCurrentPersonalTitle()
    {
        return $this->currentPersonalTitle;
    }

    /**
     * Set currentSuffix
     *
     * @param string $currentSuffix
     * @return Person
     */
    public function setCurrentSuffix($currentSuffix)
    {
        $this->currentSuffix = $currentSuffix;
    
        return $this;
    }

    /**
     * Get currentSuffix
     *
     * @return string 
     */
    public function getCurrentSuffix()
    {
        return $this->currentSuffix;
    }

    /**
     * Set currentNickname
     *
     * @param string $currentNickname
     * @return Person
     */
    public function setCurrentNickname($currentNickname)
    {
        $this->currentNickname = $currentNickname;
    
        return $this;
    }

    /**
     * Get currentNickname
     *
     * @return string 
     */
    public function getCurrentNickname()
    {
        return $this->currentNickname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Person
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
}