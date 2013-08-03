<?php

namespace Azgil\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CategoryNode
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CategoryNode
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;
	
    /**
     * @ORM\OneToMany(targetEntity="CategoryTree", mappedBy="node")
     */
    private $trees;

    public function __construct()
    {
        $this->trees = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return CategoryNode
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return CategoryNode
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    

    /**
     * Add trees
     *
     * @param \Azgil\CategoryBundle\Entity\CategoryTree $trees
     * @return CategoryNode
     */
    public function addTree(\Azgil\CategoryBundle\Entity\CategoryTree $trees)
    {
        $this->trees[] = $trees;
    
        return $this;
    }

    /**
     * Remove trees
     *
     * @param \Azgil\CategoryBundle\Entity\CategoryTree $trees
     */
    public function removeTree(\Azgil\CategoryBundle\Entity\CategoryTree $trees)
    {
        $this->trees->removeElement($trees);
    }

    /**
     * Get trees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrees()
    {
        return $this->trees;
    }
}