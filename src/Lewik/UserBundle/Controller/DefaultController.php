<?php

namespace Lewik\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LewikUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
