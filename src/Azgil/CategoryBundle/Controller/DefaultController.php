<?php

namespace Azgil\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Azgil\CategoryBundle\Doctrine\Tree;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AzgilCategoryBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function manageAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	//$tree = new Tree($em);
    	
    	$cat_table = $em->getRepository('AzgilCategoryBundle:CategoryTree')->findBy(
    			array('type'=> 1),array('path' => 'ASC'));
    	$result = 'line 1'."\n";
    	$prev = '-';
    	foreach ($cat_table as $tag) {
    			$prev_len = strlen($prev);
    			$current_len = strlen($tag->getPath());
    			$current_level = $current_len/4;
    			$prev_level = $prev_len/4;
    			
    			//$result .= $prev.'_'.$tag->getPath();
    			 
    			if ( $current_len > $prev_len) {
    				$result .= str_repeat("\t", $current_level).
    				'<ul>'."\n".
    				str_repeat("\t", $current_level).
    				'<li>'.$tag->getPath()."\n";
    			}
    			
    			if ($current_len == $prev_len) {    				
    				$result .= str_repeat("\t", $current_level).
    				'</li>'."\n".
    				str_repeat("\t", $current_level).
    				'<li>'.$tag->getPath()."\n";
    			}
    			
    			    			
    			if ( $current_len < $prev_len) {
    				for ($j = $prev_level; $j > $current_level; $j--){
    					$result .= str_repeat("\t",$j ).
    					'</li>'."\n".
    					str_repeat("\t",$j ).
    					'</ul>'."\n";
    					
    				}
    				$result .= str_repeat("\t", $current_level).    				
    				'</li>'."\n".
    				str_repeat("\t", $current_level).
    				'<li>'.$tag->getPath()."\n";
    				
    			}
    			
    			$prev = $tag->getPath();
    	}
    	
    	return $this->render('AzgilCategoryBundle:Default:manage.html.twig',
    			array('tree' => $result));
    }
}
