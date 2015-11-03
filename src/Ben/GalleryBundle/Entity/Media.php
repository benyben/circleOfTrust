<?php

namespace Ben\GalleryBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Media
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ben\GalleryBundle\Entity\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @Assert\Image()
     * @var UploadedFile file
     */
    private $file;

    /**
     * @ORM\ManyToMany(targetEntity="Ben\GalleryBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;

    public function __construct(){
        $this->categories = new ArrayCollection();
    }


    private $tempFilename;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {

        $this->file = $file;

        //verif si déjà un fichier pour cette entité
        if(null !== $this->extension){
            $this->tempFilename = $this->extension;

            $this->extension = null;
            $this->alt = null;
        }

    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preLoad(){
        if(null === $this->file){
            return;
        }

        //récupération de l'extension
        $this->extension = $this->file->guessExtension();

        //récupération de l'alt
        $this->alt = $this->file->getClientOriginalName();

    }



    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if(null === $this->file){
            return;
        }

        //si ancien fichier on le supprime
        if(null !== $this->tempFilename){
            $oldFile = $this->getUploadRootDir().'/' .$this->id .'.'. $this->tempFilename;
            if (file_exists($oldFile)){
                unlink($oldFile);
            }
        }

        //déplacement du fichier
        $this->file->move(
            $this->getUploadRootDir(),
            $this->id .'.'. $this->extension
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload(){
        //sauvegarde temporaire du nom du fichier
        $this->tempFilename = $this->getUploadRootDir() .'/'. $this->id .'.'. $this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if(file_exists($this->tempFilename)){
            unlink($this->tempFilename);
        }
    }



    public function getUploadDir(){
        //chemin relatif par rapport au dossier web
        return 'uploads/media';
    }

    public function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath(){
        return $this->getUploadRootDir().'/'.$this->getId().'.'.$this->getextension();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Media
     */
    public function setextension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getextension()
    {
        return $this->extension;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Media
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }




    public function addCategories(Category $category){
        $this->categories[] = $category;
        return $this;
    }

    public function removedCategory(Category $category){
        $this->categories->removeElement($category);
    }



    public function getCategories()
    {
        return $this->categories;
    }



    /**
     * Add category
     *
     * @param \Ben\GalleryBundle\Entity\Category $category
     *
     * @return Media
     */
    public function addCategory(\Ben\GalleryBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Ben\GalleryBundle\Entity\Category $category
     */
    public function removeCategory(\Ben\GalleryBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }
}
