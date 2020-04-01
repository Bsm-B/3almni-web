<?php

namespace AlmniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Almni/front/Default/index.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('@Almni/front/Default/aboutus.html.twig');
    }
}
