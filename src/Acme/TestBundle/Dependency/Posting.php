<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Task
 *
 * @author shayan
 */
namespace Acme\TestBundle\Dependency;

class Posting 
{
    protected $id;
    
    public function __construct() {
        
        $this->setId(369369);
    }

        public function getId()
    {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
}
