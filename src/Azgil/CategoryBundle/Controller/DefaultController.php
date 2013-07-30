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
    	$tree = new Tree($em);
    	return $this->render('AzgilCategoryBundle:Default:manage.html.twig',
    			array('tree' => $tree->generateTree(1), 'nodes' => $tree->getLastNodes(1)));
    }
}
