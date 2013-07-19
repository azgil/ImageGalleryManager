<?php

namespace Azgil\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('creationDate')
            ->add('createdBy')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Azgil\GalleryBundle\Entity\Picture'
        ));
    }

    public function getName()
    {
        return 'azgil_gallerybundle_picturetype';
    }
}
