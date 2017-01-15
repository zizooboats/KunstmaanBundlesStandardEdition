<?php

namespace Zizoo\Bundle\CmsBundle\Form\PageParts;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Entity\PageParts\IconBulletPointPagePart;
use Zizoo\Bundle\CmsBundle\Form\IconBulletPointAdminType;

/**
 * IconBulletPointPagePartAdminType
 */
class IconBulletPointPagePartAdminType extends AbstractType
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

        $builder->add('alignment', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'required' => true,
            'choices' => array(
                IconBulletPointPagePart::HORIZONTAL_ALIGNMENT => 'Horizontal',
                IconBulletPointPagePart::VERTICAL_ALIGNMENT => 'Vertical'
            )
        ));
        
        $builder
            ->add('iconBulletPoints', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
                    'entry_type' => new IconBulletPointAdminType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'label' => 'zizoo_cms_bundle.iconbulletpointpagepart.icon_bullet_points',
                    'cascade_validation' => true,
                    'attr' => array(
                        'nested_form' => true,
                        'nested_form_min' => 1,
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
        return 'iconbulletpointpageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zizoo\Bundle\CmsBundle\Entity\PageParts\IconBulletPointPagePart',
            'cascade_validation' => true,
        ));
    }
}
