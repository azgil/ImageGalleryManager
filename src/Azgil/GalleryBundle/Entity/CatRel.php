<?php

namespace Azgil\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatRel
 *
 * @ORM\Table(name="CatRelPic")
 * @ORM\Entity(repositoryClass="Azgil\GalleryBundle\Entity\CatRelRepository")
 */
class CatRel
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
     * @ORM\Column(name="cat_id", type="integer")
     */
    private $catId;

    /**
     * @var integer
     *
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $entityId;


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
     * Set catId
     *
     * @param integer $catId
     * @return CatRel
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
    
        return $this;
    }

    /**
     * Get catId
     *
     * @return integer 
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     * @return CatRel
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    
        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer 
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
}