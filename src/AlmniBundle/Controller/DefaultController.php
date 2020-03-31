<?php

namespace AlmniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Almni/Default/index.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('@Almni/Default/aboutus.html.twig');
    }
}
