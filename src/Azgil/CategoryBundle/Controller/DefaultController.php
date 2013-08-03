<?php

namespace Azgil\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Azgil\CategoryBundle\Doctrine\Tree;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AzgilCategoryBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function manageAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$tree = new Tree($em);
    	return $this->render('AzgilCategoryBundle:Default:manage.html.twig',
    			array('tree' => $tree->generateTree(1), 'nodes' => $tree->getLastNodes(1)));
    }
    
    public function fetchNodesAction()
    {    	
    	$key = $this->getRequest()->request->get('key');
    	$em = $this->getDoctrine()->getEntityManager();
    	$tree = new Tree($em);
    	
    	$response = array("code" => 100, "success"=> true, "nodes" => $tree->fetcNodes($key,1));
    	return new Response(json_encode($response));
    		
    }
    
    public function saveTreeAction()
    {
    	$html = $this->getRequest()->request->get('htm');
    	//$html = str_replace("<li><ul>", "<li>", $html);
    	//$html = strip_tags($html , "<li>");
    	$html = str_replace("<br>", '', $html);	
    	$tree = new \DOMDocument();
    	$tree->loadXML($html);
        
    	foreach ($tree->getElementsByTagName('li')as $node){
    		$html .= $node->getNodePath()."<br>";
                $path = $node->getNodePath();
                $ids = explode('/ul/li', $path);
                $path = 'id = ' . $node->getAttribute('id') . '   ' ;
                unset($ids[0]);
                foreach ($ids as $id){                    
                    if (!$id) {
                        $path .= '-001';
                    }  else {
                    	$digit = intval( str_replace(array("[","]"), '', $id) );
                    	if ($digit < 10) 
                    		$path .= '-00' . $digit;
                    	elseif ($digit < 100)
                    		$path .= '-0' . $digit;
                    	else 
                        	$path .= '-' . $digit;
                    }
                }
                $html .= $path."<br>";
    	}
    	$response = array("code" => 100, "success"=> true, "nodes" => $html.'ss');
    	return new Response(json_encode($response));
    }
}
