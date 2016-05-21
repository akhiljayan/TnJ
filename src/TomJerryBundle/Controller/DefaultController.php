<?php

namespace TomJerryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TomJerryBundle:MainsiteSection:index.html.twig');
    }
}
