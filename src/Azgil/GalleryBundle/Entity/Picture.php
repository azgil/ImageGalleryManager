<?php

namespace Azgil\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Azgil\JalaliBundle\Services\Converter;

/**
 * Picture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Azgil\GalleryBundle\Entity\PictureRepository")
 */
class Picture
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="creation_date", type="string", length=10, nullable=true)
     */
    private $creationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=TRUE, options={"default":TRUE})
     */
    private $isActive;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=TRUE, options={"default":TRUE})
     */
    private $visible;

    public function __construct() {
        $converter = new Converter();
        $dateArray = $converter->GregorianToJalali(date('Y'), date('m'), date('d'));
        $this->creationDate = $dateArray[0]."/".$dateArray[1]."/".$dateArray[2];
        
        $this->isActive = TRUE;
        $this->visible = TRUE;
        
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
     * @return Picture
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
     * Set creationDate
     *
     * @param string $creationDate
     * @return Picture
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return string 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return Picture
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    

    /**
     * Set name
     *
     * @param string $name
     * @return Picture
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
     * Get absolute path
     *
     * @return string 
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }
    
    /**
     * Get web path
     *
     * @return string 
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }
    
    /**
     * Get upload root dir
     *
     * @return string 
     */
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get upload dir
     *
     * @return string 
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/img/thumbnails';
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Picture
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Picture
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    
        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
}