<?php
namespace Neutron\Widget\SocialNetworksBundle;

use Neutron\MvcBundle\MvcEvents;

use Symfony\Component\Translation\TranslatorInterface;

use Neutron\MvcBundle\Event\ConfigureWidgetEvent;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neutron\MvcBundle\Widget\WidgetFactoryInterface;

use Neutron\MvcBundle\Model\Widget\WidgetManagerInterface;

class SocialNetworksWidget
{
    const IDENTIFIER = 'neutron.widget.social_networks';
    
    protected $dispatcher;
    
    protected $factory; 
    
    protected $manager;
    
    protected $translator;
    
    protected $options;

    public function __construct(EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, 
        WidgetManagerInterface $manager, TranslatorInterface $translator, array $options)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->manager = $manager;
        $this->translator = $translator;
        $this->options = $options;
    }
    
    public function build()
    {
        $widget = $this->factory->createWidget(self::IDENTIFIER);
        $widget
            ->setLabel($this->translator->trans('widget.neutron_social_networks.label', array(), 'NeutronSocialNetworksBundle'))
            ->setDescription($this->translator->trans('widget.neutron_social_networks.desc', array(), 'NeutronSocialNetworksBundle'))
            ->setAdministrationRoute('neutron_social_networks.administration')
            ->setFrontController('neutron_social_networks.controller.front:indexAction')
            ->setManager($this->manager)
            ->enablePluginAware($this->options['plugin_aware'])
            ->setAllowedPlugins($this->options['allowed_plugins'])
            ->enablePanelAware($this->options['panel_aware'])
            ->setAllowedPanels($this->options['allowed_panels'])
        ;
        
        $this->dispatcher->dispatch(
            MvcEvents::onWidgetConfigure,
            new ConfigureWidgetEvent($this->factory, $widget)
        );
 
        return $widget;
    }
}