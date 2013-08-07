<?php

namespace Azgil\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Azgil\CategoryBundle\Doctrine\Tree;
use \Symfony\Component\HttpFoundation\Response;
use Azgil\CategoryBundle\Entity\CategoryNode;
use Azgil\CategoryBundle\Entity\CategoryTree;

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
    	$type = $this->getRequest()->request->get('type');
    	$html = str_replace("<br>", '', $html);	
    	$tree = new \DOMDocument();
    	$tree->loadXML($html);
        $branches = array();
    	foreach ($tree->getElementsByTagName('li') as $node){
    		$em = $this->getDoctrine()->getManager();
    		$html .= $node->getNodePath()."<br>";
    		$path = $node->getNodePath();
            $ids = explode('/ul/li', $path);
            $path = '';
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
            
            $tree_node = $em->getRepository('AzgilCategoryBundle:CategoryNode')->find($node->getAttribute('id'));
            $tree_branch = new CategoryTree();
            $tree_branch->setNode($tree_node);
            $tree_branch->setPath($path);
            $tree_branch->setType($type);
            $branches[] = $tree_branch;
            
            
            
            
    	}
    	
    	$del = $em->getRepository('AzgilCategoryBundle:CategoryTree')->findByType($type);
    	foreach ($del as $d)
    		$em->remove($d);
    	$em->flush();
    	
    	foreach ($branches as $b)
    		$em->persist($b);
    	$em->flush();
    	
    	$response = array("code" => 100, "success"=> true, "nodes" => $html.'ss');
    	return new Response(json_encode($response));
    }
}
