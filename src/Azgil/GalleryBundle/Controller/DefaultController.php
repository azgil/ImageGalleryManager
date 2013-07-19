<?php

namespace Azgil\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AzgilGalleryBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function showImageAction(){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AzgilGalleryBundle:Picture')->findAll();

        return $this->render('AzgilGalleryBundle:Default:showimage.html.twig', array(
            'entities' => $entities,
        ));
    }
}
