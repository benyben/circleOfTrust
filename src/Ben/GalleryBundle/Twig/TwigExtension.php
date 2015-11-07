<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 07/11/2015
 * Time: 13:31
 */

namespace Ben\GalleryBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\HttpKernel\KernelInterface;



class TwigExtension extends \Twig_Extension
{
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine = $doctrine;
    }

    public function getName() {
        return 'galleryTwigExt';
    }

    public function getMediasByCategory()
    {
        $med = $this->doctrine->getRepository('BenGalleryBundle:Media');
       return $pictures = $med->findMediasByCategory(1);
    }

        public function getFunctions(){
       return array(
           'getPicturesByCategory' => new \Twig_Function_Method($this, 'getPicturesByCategory')
       );
    }


}