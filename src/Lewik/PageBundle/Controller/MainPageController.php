<?php

namespace Lewik\PageBundle\Controller;

use Lewik\PageBundle\Controller\CommonController;

class MainPageController extends CommonController
{
    protected $template = 'LewikPageBundle:Default:index.html.twig';

    public function indexAction()
    {
        return $this->commonRender();
    }

}
