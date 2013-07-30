<?php

namespace Azgil\JalaliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $converter = $this->get('azgil_jalali.converter');
        $creationDate = $converter->GregorianToJalali(date('Y'), date('m'), date('d'));
        $now = $creationDate[0]."/".$creationDate[1]."/".$creationDate[2];
        return $this->render('AzgilJalaliBundle:Default:index.html.twig', array('name' => $now));
    }
}
