<?php

namespace Ben\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ben\NewsBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Ben\NewsBundle\Form\Type\AddPostType;

class NewsController extends Controller
{
    public function indexAction(Request $request)
    {

        $post = new Post();

        $formBuilder = $this->createFormBuilder($post);

        $formBuilder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('content', 'textarea', array('label' => 'Message'));

        $form = $formBuilder->getForm();

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $user = $this->getUser();
                $post->setUser($user);

                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();

                return $this->redirect($this->generateUrl('news_home'));
            }
        }


        //récupération des posts
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BenNewsBundle:Post');
        $postsArray = $repo->findAll();


        return $this->render('BenNewsBundle:News:index.html.twig', array(
            'form' => $form->createView(),
            'postsArray' => $postsArray
        ));

    }

    public function addPostAction(Request $request)
    {
       $post = new Post();

        $formBuilder = $this->createFormBuilder($post);

        $formBuilder
            ->add('title', 'text')
            ->add('content', 'textarea');

        $form = $formBuilder->getForm();

        if($request->isXmlHttpRequest()){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();
            }
        }

        //récupération des posts
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BenNewsBundle:Post');
        $postsArray = $repo->findAll();


        return $this->render('BenNewsBundle:News:add.html.twig', array(
            'form' => $form->createView(),
            'postsArray' => $postsArray
        ));
    }


}
