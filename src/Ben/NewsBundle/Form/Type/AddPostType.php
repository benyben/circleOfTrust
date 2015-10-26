<?php

namespace Ben\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' =>'Titre'))
            ->add('content', 'textarea', array('label' =>'message'))
            ->add('Enregistrer','submit');
    }

    public function getName()
    {
        return 'NewsForm';
    }
}
