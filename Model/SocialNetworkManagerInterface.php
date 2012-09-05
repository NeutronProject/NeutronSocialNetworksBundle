<?php
namespace Neutron\Widget\SocialNetworksBundle\Model;

use Neutron\LayoutBundle\Model\Widget\WidgetInstanceInterface;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

interface SocialNetworkManagerInterface extends WidgetManagerInterface, WidgetInstanceInterface
{
    public function getSocialLinks();
    
    public function getQueryBuilderForDataGrid();
    
    public function create();
    
    public function update(SocialNetworkInterface $entity, $andFlush = true);
    
    public function delete(SocialNetworkInterface $entity, $andFlush = true);
    
    public function findOneBy(array $criteria);
    
    public function changePosition(SocialNetworkInterface $entity, $position);
    
    public function getLinkClasses();
}