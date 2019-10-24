<?php

namespace Zizoo\Bundle\CmsBundle\Form\PageParts;

use Kunstmaan\FormBundle\Form\EmailFormSubmissionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DownloadWithEmailPagePartType extends AbstractType
{
    /**
     * @var string $buttonLabel
     */
    private $buttonLabel = '';

    public function __construct($buttonLabel = null)
    {
        if(!is_null($buttonLabel)) {
            $this->buttonLabel = $buttonLabel;
        }
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                    'label' => " ",
                    'attr' => array(
                        'placeholder' => "E-mail"
                    )
                )
            )
            ->add('save', SubmitType::class, array(
                    'label' => $this->buttonLabel,
                    'attr' => array(
                        'class' => 'email-submit'
                    )
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zizoo\Bundle\CmsBundle\Entity\DownloadEmail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'downloadwithemailpagepart';
    }
}
