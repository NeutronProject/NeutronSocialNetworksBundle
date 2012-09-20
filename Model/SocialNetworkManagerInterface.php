<?php
namespace Neutron\Widget\SocialNetworksBundle\Model;

use Neutron\MvcBundle\Model\Widget\WidgetInstanceInterface;

use Neutron\MvcBundle\Model\Widget\WidgetManagerInterface;

interface SocialNetworkManagerInterface extends WidgetManagerInterface, WidgetInstanceInterface
{
    public function getSocialLinks();
    
    public function getQueryBuilderForDataGrid();
    
    public function changePosition(SocialNetworkInterface $entity, $position);
    
    public function getLinkClasses();
}