<?php


namespace Azgil\CategoryBundle\Doctrine;

use Doctrine\ORM\EntityManager;

class XML {
    
    protected $em;
    protected $xml;


    function __construct(EntityManager $em) {
        $this->em = $em;
        
        
    }
    
    public function catToXml(){
        $cat_table = $this->em->getRepository('AzgilCategoryBundle:Category')->findAll();
        $this->xml = '<div class="node_mouse_leave" id="cat_manager_div">';
        $this->xml .= '<div><input type="button" /></div>';
        $this->arrayToXml($cat_table, null,1);
        $this->xml .= '</div>';
        return $this->xml;
        
    }
    
    public function arrayToXml(array $table, $id, $level ) {
        for($i = 0 ; $i < $level-1 ; $i++)$this->xml .= "\t";
        $this->xml .= '<ul>'."\n";
        foreach ($table as $category) {
            $parentid = $category->getParentId();
            if($parentid == $id){
                for($i = 0 ; $i < $level ; $i++)$this->xml .= "\t";
                $this->xml .= '<li class="cat_node" id="'.$category->getId().
                                  '" path="'.$category->getPath().'">'.$category->getTitle().'<div class="cat_node_icon"><img src="/bundles/usersmanager/images/animated-overlay.gif" /></div> </li>'."\n";
                
                $this->arrayToXml($table, $category->getId(), $level+1);
                
            }            
        }
        for($i = 0 ; $i < $level-1 ; $i++)$this->xml .= "\t";
        $this->xml .= "</ul>\n";
    }
    
}

?>
