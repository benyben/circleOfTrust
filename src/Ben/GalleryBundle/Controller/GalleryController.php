<?php

namespace Ben\GalleryBundle\Controller;

use Ben\GalleryBundle\Entity\Media;
use Ben\GalleryBundle\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{
    public function indexAction(Request $request)
    {
        $media = new Media();

        $form = $this->createForm(new MediaType(),$media);

        if($form->handleRequest($request)->isValid()){

            $media->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            return $this->redirectToRoute('gallery_home');
            }


        //Récupération des photos
        $repo = $this->getDoctrine()->getRepository('BenGalleryBundle:Media');
        $photos = $repo->findAll();


        return $this->render('BenGalleryBundle:Gallery:index.html.twig',array(
            'form' => $form->createView(),
            'media' => $media,
            'photos' =>$photos
            ));
    }


}
