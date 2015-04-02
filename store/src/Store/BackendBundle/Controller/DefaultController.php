<?php

namespace store\backendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StorebackendBundle:Default:index.html.twig', array('name' => $name));
    }
}
