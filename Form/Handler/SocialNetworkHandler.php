<?php
namespace Neutron\Widget\SocialNetworksBundle\Form\Handler;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class SocialNetworkHandler extends AbstractFormHandler
{

    protected $socialNetworksManager;
    
    public function setSocialNetworksManager(SocialNetworkManagerInterface $socialNetworkManager)
    {
        $this->socialNetworksManager = $socialNetworkManager;
    }
    
    protected function onSuccess()
    {
        $socialNetwork = $this->form->get('general')->getData();
        $this->socialNetworksManager->update($socialNetwork, true);        
    }
    
    public function getRedirectUrl()
    {
        return $this->router->generate('neutron_social_networks.administration');
    }

}
