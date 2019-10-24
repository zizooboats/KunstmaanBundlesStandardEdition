<?php

namespace Zizoo\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Zizoo\Bundle\CmsBundle\Entity\IconBulletPoint;

/**
 * IconBulletPointPagePartAdminType
 */
class IconBulletPointAdminType extends AbstractType
{

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('icon', 'Kunstmaan\MediaBundle\Form\Type\MediaType', array(
            'mediatype' => 'image',
            'cascade_validation' => true,
            'required' => true,
        ));
        $builder->add('circleColor', 'Kunstmaan\AdminBundle\Form\ColorType', array(
            'required' => true,
        ));
        $builder->add('title', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'required' => true,
        ));
        $builder->add('content', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'attr' => array('rows' => 10, 'cols' => 600),
            'required' => false,
        ));
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zizoo\Bundle\CmsBundle\Entity\IconBulletPoint',
            'cascade_validation' => true,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'iconbulletpointtype';
    }
}
