<?php
/*
 * This file is part of NeutronSocialNetworksBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\SocialNetworksBundle\EventListener;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

use Neutron\Widget\SocialNetworksBundle\DataGrid\SocialNetworkDataGrid;

use Neutron\Bundle\DataGridBundle\Event\RowPositionChangeEvent;

/**
 *  DataGridPositionChangeListener
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class DataGridRowPositionChangeListener
{
    
    protected $manager;
    
    public function __construct(SocialNetworkManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    /**
     * This method is trigged when onRowSort event is dispatched
     * 
     * @param RowSortEvent $event
     * @return void
     */
    public function onRowPositionChange(RowPositionChangeEvent $event)
    {   
        if (!$event->getDataGridName() == SocialNetworkDataGrid::IDENTIFIER){
            return;
        }

        $this->changePosition($event->getRowId(), $event->getRowPosition());
    }
    
    protected function changePosition($id, $position)
    {
        $entity = $this->manager->findOneBy(array('id' => $id));
        $this->manager->changePosition($entity, $position);
    }

}
