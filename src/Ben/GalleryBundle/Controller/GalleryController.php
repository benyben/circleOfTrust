<?php

namespace Ben\GalleryBundle\Controller;

use Ben\GalleryBundle\Entity\Media;
use Ben\GalleryBundle\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GalleryController extends Controller
{
    public function indexAction(Request $request)
    {
        $media = new Media();

        $form = $this->createForm(new MediaType(),$media);

        if($form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            return $this->redirectToRoute('gallery_home');
            }

        $category = $this->getDoctrine()->getRepository('BenGalleryBundle:Category');
        $categories = $category->findAll();

        $med = $this->getDoctrine()->getRepository('BenGalleryBundle:Media');
        $med->find(1);


        return $this->render('BenGalleryBundle:Gallery:index.html.twig',array(
            'form' => $form->createView(),
            'media' => $media,
            'categories' => $categories

            ));
    }


    public function editAction($id,Request $request){
        $em = $this->getDoctrine()->getManager();

        //récupération de la catégorie

        $category = $em->getRepository('BenGalleryBundle:Category')->find($id);

        if (null === $category){
            throw new NotFoundHttpException("L'annonce d'id " .id." n'existe pas");
        }

        //récupération de tous les médias
        $listMedias = $em->getRepository('BenGalleryBundle:Media')->findAll();

       

        $em->flush();

       return $this->redirect('gallery_home');
    }

}
