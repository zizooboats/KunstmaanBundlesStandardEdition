<?php

namespace Zizoo\Bundle\CmsBundle\Form\PageParts;

use Kunstmaan\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;

/**
 * DownloadWithEmailPagePartAdminType
 */
class DownloadWithEmailPagePartAdminType extends \Symfony\Component\Form\AbstractType
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
            ->add('title', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'zizoo_cms_bundle.downloadwithemailpagepart.title',
                    'required' => false
                )
            )
            ->add('media', MediaType::class, array(
                    'label' => 'mediapagepart.download.choosefile',
                    'required' => true,
                )
            )
            ->add('image', MediaType::class, array(
                    'label' => 'zizoo_cms_bundle.downloadwithemailpagepart.image',
                    'mediatype' => 'image',
                    'required' => false,
                )
            )
            ->add('overlayImageText', TextType::class)
            ->add('buttonText', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'zizoo_cms_bundle.downloadwithemailpagepart.button_label',
                    'required' => false,
                )
            )
            ->add('successMessage', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'zizoo_cms_bundle.downloadwithemailpagepart.success_message',
                    'required' => false
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
        return 'zizoo_bundle_cmsbundle_downloadwithemailpageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\Zizoo\Bundle\CmsBundle\Entity\PageParts\DownloadWithEmailPagePart'
        ));
    }
}
