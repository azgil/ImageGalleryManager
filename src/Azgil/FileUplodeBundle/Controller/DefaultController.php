<?php

namespace Azgil\FileUplodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AzgilFileUplodeBundle:Default:index.html.twig', array('name' => $name));
    }
}
