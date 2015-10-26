<?php

namespace Ben\CircleOfTrustBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('BenCircleOfTrustBundle:Home:index.html.twig');
    }
}
