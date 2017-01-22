<?php

namespace Zizoo\Bundle\CmsBundle\Form\PageParts;

use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Kunstmaan\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoPagePartAdminType extends AbstractType
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
        $builder
            ->add('video', MediaType::class, array(
                    'mediatype' => 'video',
                    'required' => true
                )
            )
            ->add('videoWidth', TextType::class, array(
                    'required' => false,
                    'label' => 'zizoo_cms_bundle.videopagepart.video_width_label',
                    'attr' => array(
                        'placeholder' => '50'
                    )
                )
            )
            ->add('videoHeight', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                    'required' => false,
                    'label' => 'zizoo_cms_bundle.videopagepart.video_height_label',
                    'attr' => array(
                        'placeholder' => '50'
                    )
                )
            )
            ->add('caption', TextType::class, array(
                    'required' => false
                )
            );


        $builder
            ->get('videoWidth')
            ->addModelTransformer(new CallbackTransformer(
                    function ($videoWidth) {
                        return $videoWidth;
                    },
                    function ($videoWidthString) {
                        return (int)$videoWidthString;
                    }
                )
            )
        ;

        $builder
            ->get('videoHeight')
            ->addModelTransformer(new CallbackTransformer(
                    function ($videoHeight) {
                        return $videoHeight;
                    },
                    function ($videoHeightString) {
                        return (int)$videoHeightString;
                    }
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
	    return 'videopageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zizoo\Bundle\CmsBundle\Entity\PageParts\VideoPagePart',
        ));
    }
}
