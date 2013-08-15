<?php

namespace Lewik\SystemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommonController extends Controller
{
    protected $data = array();
    protected $template = '';


    public function commonRender()
    {
        return parent::render($this->template,$this->data);
    }
}
