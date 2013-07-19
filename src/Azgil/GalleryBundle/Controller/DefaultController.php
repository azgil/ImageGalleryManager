<?php

namespace Azgil\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AzgilGalleryBundle:Default:index.html.twig', array('name' => $name));
    }
}
