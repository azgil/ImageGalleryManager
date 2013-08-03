<?php

namespace Azgil\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryTree
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Azgil\CategoryBundle\Entity\CategoryTreeRepository")
 */
class CategoryTree
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
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="CategoryNode", inversedBy="trees")
     * @ORM\JoinColumn(name="node_id", referencedColumnName="id")
     */
    private $node;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

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
     * Set type
     *
     * @param integer $type
     * @return CategoryTree
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
     * Set path
     *
     * @param string $path
     * @return CategoryTree
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Set node
     *
     * @param \Azgil\CategoryBundle\Entity\CategoryNode $node
     * @return CategoryTree
     */
    public function setNode(\Azgil\CategoryBundle\Entity\CategoryNode $node = null)
    {
        $this->node = $node;
    
        return $this;
    }

    /**
     * Get node
     *
     * @return \Azgil\CategoryBundle\Entity\CategoryNode 
     */
    public function getNode()
    {
        return $this->node;
    }
}