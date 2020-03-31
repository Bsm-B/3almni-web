<?php

namespace AlmniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Almni/Admin/Default/index.html.twig');
    }

    public function testAction()
    {
        return $this->render('@Almni/Admin/Default/test.html.twig');
    }

}
