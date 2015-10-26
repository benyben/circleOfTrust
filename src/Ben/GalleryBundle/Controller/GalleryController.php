<?php

namespace Ben\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GalleryController extends Controller
{
    public function indexAction()
    {
        $formbuilder = $this->createFormBuilder();

        $formbuilder
            ->add('img','file', array('label' =>'Charger une photo'))
            ->add('Charger','submit');

       $form = $formbuilder->getForm();


        return $this->render('BenGalleryBundle:Gallery:index.html.twig',array(
            'form' => $form->createView(),
            ));
    }

    public function addAction()
    {
       $formbuilder = $this->createFormBuilder();

        $formbuilder
            ->add('img','file', array('label' =>'Charger une photo'))
            ->add('Charger','submit');
    }
}
