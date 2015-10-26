<?php

namespace Ben\TchatBundle\Controller;

use Ben\TchatBundle\Entity\TchatPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TchatController extends Controller
{
    public function indexAction()
    {

        $repo = $this->getDoctrine()->getRepository('BenTchatBundle:TchatPost');
        $tchatResult = $repo->findAll();

        return $this->render('BenTchatBundle:Tchat:index.html.twig',array(
            'tchatArray' => $tchatResult
        ));
    }
}
