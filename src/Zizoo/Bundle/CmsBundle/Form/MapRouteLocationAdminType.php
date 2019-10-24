<?php

namespace Zizoo\Bundle\CmsBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
        $builder->add('region', EntityType::class, array(
                'class' => 'Zizoo\Bundle\CmsBundle\Entity\Region',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                              ->orderBy('r.internalName', 'ASC');
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
