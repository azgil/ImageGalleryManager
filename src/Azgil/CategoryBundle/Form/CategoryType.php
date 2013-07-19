<?php

namespace Azgil\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parentId')
            ->add('title')
            ->add('path')
            ->add('type')
            ->add('is_active')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Azgil\CategoryBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'azgil_categorybundle_categorytype';
    }
}
