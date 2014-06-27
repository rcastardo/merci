<?php

namespace Merci\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Merci\UserBundle\Form\EventListener\AddPasswordFieldSubscriber;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'class' => 'form-control col-md-6'
                ),
                'label' => 'Nome',
                'required' => true,
                )
            )
            ->add('email', 'email')
            ->add('address', new AddressType())
            ->add('save', 'submit');

            $builder->addEventSubscriber(new AddPasswordFieldSubscriber());
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //cascade_validation valida dois forms
        $resolver->setDefaults(array(
            'data_class' => 'Merci\UserBundle\Entity\User',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'merci_userbundle_user';
    }
}
