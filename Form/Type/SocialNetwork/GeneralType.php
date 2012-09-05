<?php
/*
 * This file is part of NeutronSocialNetworksBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\SocialNetworksBundle\Form\Type\SocialNetwork;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class GeneralType extends AbstractType
{    
    protected $manager;
    
    protected $dataClass;
    
    public function __construct(SocialNetworkManagerInterface $manager, $dataClass)
    {
        $this->manager = $manager;
        $this->dataClass = $dataClass;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'form.name',
                'translation_domain' => 'NeutronSocialNetworksBundle'
            ))
            ->add('linkClass', 'choice', array(
                'choices' => $this->manager->getLinkClasses(),
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.linkClass',
                'empty_value' => 'form.empty_value',
                'translation_domain' => 'NeutronSocialNetworksBundle'
            ))
            ->add('linkUrl', 'url', array(
                'label' => 'form.url',
                'translation_domain' => 'NeutronSocialNetworksBundle'
            ))
            ->add('linkTarget', 'choice', array(
                'choices' => array('_self' => 'target.self', '_blank' => 'target.blank'),
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.linkTarget',
                'empty_value' => 'form.empty_value',
                'translation_domain' => 'NeutronSocialNetworksBundle'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'form.enabled', 
                'value' => 1,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => 'NeutronSocialNetworksBundle'
            ))
        ;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
            'validation_groups' => function(FormInterface $form){
                return 'default';
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_social_network_general';
    }
}