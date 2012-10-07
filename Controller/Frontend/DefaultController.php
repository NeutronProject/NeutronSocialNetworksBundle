<?php

namespace Neutron\Widget\SocialNetworksBundle\Controller\Frontend;

use Neutron\UserBundle\Model\BackendRoles;

use Neutron\Bundle\AsseticBundle\Controller\AsseticController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class DefaultController extends ContainerAware
{
    
    public function indexAction($widgetInstanceId)
    {         
        $manager = $this->container->get('neutron_social_networks.manager');
        
        $links = $manager->getSocialLinks();

        $template = $this->container->get('templating')
            ->render($this->container->getParameter('neutron_social_networks.template'), array(
                'label' => $manager->getLabel(),
                'links' => $links
            )
        );
    
        return  new Response($template);
    }
    
}
