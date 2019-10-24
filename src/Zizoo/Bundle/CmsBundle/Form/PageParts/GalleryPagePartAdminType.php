<?php

namespace Zizoo\Bundle\CmsBundle\Form\PageParts;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;

/**
 * GalleryPagePartAdminType
 */
class GalleryPagePartAdminType extends \Symfony\Component\Form\AbstractType
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
        $builder
            ->add('galleryAltText', TextType::class, array(
                    'required' => false,
                    'label' => 'zizoo_cms_bundle.gallerypagepart.gallery_caption'
                )
            )
            ->add('gallery', CollectionType::class, array(
                    'entry_type' => 'Kunstmaan\MediaBundle\Form\Type\MediaType',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'label' => 'zizoo_cms_bundle.gallerypagepart.gallery',
                    'attr' => array(
                        'nested_form'           => true,
                        'nested_form_min'       => 1,
                        'nested_sortable'       => false,
                    )
                )
            )
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'zizoo_bundle_cmsbundle_gallerypageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\Zizoo\Bundle\CmsBundle\Entity\PageParts\GalleryPagePart'
        ));
    }
}
