<?php

namespace Zizoo\Bundle\CmsBundle\Form\PageParts;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;

/**
 * ContentSectionPagePartAdminType
 */
class ContentSectionPagePartAdminType extends \Symfony\Component\Form\AbstractType
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

        $builder->add('header', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'required' => false,
        ));
        $builder->add('content', 'Kunstmaan\AdminBundle\Form\WysiwygType', array(
            'required' => false,
        ));
        $builder->add('quote', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'required' => false,
        ));
        $builder->add('image', 'Kunstmaan\MediaBundle\Form\Type\MediaType', array(
            'mediatype' => 'image',
            'label' => 'Image (min:338x172 - max:565x353)',
            //            'constraints' => array(new Assert\Media(array(
            //                'minHeight' => '172',
            //                'maxHeight' => '353',
            //                'minWidth' => '338',
            //                'maxWidth' => '565',
            //            ))),
            'required' => false,
        ));
        $builder->add('imageAltText', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'required' => false,
            'label'    => 'Image caption'
        ));
        $builder->add('overlayImageText', TextType::class, array(
            'required' => false,
            'label' => 'zizoo_cms_bundle.overlayimage.text'
        ));
        $builder->add('imageRight', CheckboxType::class, array(
            'required' => false,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'zizoo_cmsbundle_contentsectionpageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\Zizoo\Bundle\CmsBundle\Entity\PageParts\ContentSectionPagePart'
        ));
    }
}
