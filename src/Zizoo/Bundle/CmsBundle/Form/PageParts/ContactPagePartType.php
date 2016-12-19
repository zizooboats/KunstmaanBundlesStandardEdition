<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.12.16.
     * Time: 12:57
     */

    namespace Zizoo\Bundle\CmsBundle\Form\PageParts;


    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ContactPagePartType extends AbstractType
    {
        private $emailTo;
        private $subject;

        public function __construct ($emailTo, $subject)
        {
            $this->emailTo = $emailTo;
            $this->subject = $subject;
        }


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

            $builder->add('name', 'text',
                    array(
                        'required' => true,
                        'mapped' => false,
                        'attr' => array(
                            'placeholder' => 'Your Name'
                        )
                    )
                )
                ->add('email_from', 'email',
                    array(
                        'required' => true,
                        'mapped' => false,
                        'attr' => array(
                            'placeholder' => 'E-mail'
                        ),
                    )
                )
                ->add('country', 'country',
                    array(
                        'required' => true,
                        'mapped' => false,
                        'data' => 'DE',
                    )
                )
                ->add('phone_number', 'text',
                    array(
                        'required' => false,
                        'mapped' => false,
                        'attr' => array(
                            'placeholder' => 'Phone number'
                        )
                    )
                )
                ->add('message', 'textarea',
                    array(
                        'required' => true,
                        'mapped' => false,
                        'attr' => array(
                            'placeholder' => 'Your message'
                        )
                    )
                )
                ->add('email_to', 'hidden',
                    array(
                        'data' => $this->emailTo
                    )
                )
                ->add('subject', 'hidden',
                    array(
                        'data' => $this->subject
                    )
                )
                ->add('send', 'submit', array(
                        'label' => 'Send message',
                        'attr' => array(
                            'class' => 'contact-submit'
                        )
                    )
                )
            ;
        }


        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => null,
                'attr' => array(
                    'class' => 'cf'
                ),
            ));
        }

        /**
         * Returns the name of this type.
         *
         * @return string The name of this type
         */
        public function getBlockPrefix()
        {
            return 'contactpageparttype';
        }



        /**
         * Returns the name of this type.
         *
         * @return string The name of this type
         */
        public function getName()
        {
            return $this->getBlockPrefix();
        }
    }