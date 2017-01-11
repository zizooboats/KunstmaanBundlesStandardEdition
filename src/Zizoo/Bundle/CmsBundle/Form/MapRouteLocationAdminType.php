<?php

namespace Zizoo\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MapRouteLocationAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
                    'required' => false
                )
            )
            ->add('dayNumber', 'Symfony\Component\Form\Extension\Core\Type\HiddenType' , array(
                    'attr' => array(
                        'class' => 'map-region-location-day-number-hidden-input'
                    )
                )
            )
            ->add('region')
        ;

        $builder->get('dayNumber')
            ->addModelTransformer(new CallbackTransformer(
                    function ($dayNumber) {
                        return $dayNumber;
                    },
                    function ($dayNumberAsString) {
                        return (int)$dayNumberAsString;
                    }
                )
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zizoo\Bundle\CmsBundle\Entity\MapRouteLocation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'maproutelocationtype';
    }
}
