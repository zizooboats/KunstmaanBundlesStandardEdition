<?php

namespace Zizoo\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TestimonialAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('image', 'Kunstmaan\MediaBundle\Form\Type\MediaType', array(
            'mediatype' => 'image',
            'required' => false,
        ));
        $builder->add('imageAltText', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'required' => false,
        ));
        $builder->add('content', 'Kunstmaan\AdminBundle\Form\WysiwygType', array(
            'required' => false,
            'attr' => array(
                'class' => 'js-rich-editor',
                'type' => 'full'
            )
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zizoo\Bundle\CmsBundle\Entity\Testimonial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'testimonialtype';
    }
}
