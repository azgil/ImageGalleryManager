<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class GregwarController extends Controller {

    public function indexAction() {
        $this->get('image.handling')->open('@AcmeTestBundle/Resources/public/images/33278.jpg')
                ->grayscale()
                ->rotate(12)
                ->save('/var/www/html/azgil/amoosibiloo.com/web/uploads/test.jpg');
        return $this->render('AcmeTestBundle:Default:index.html.twig', array('name' => '$name'));
    }

}
