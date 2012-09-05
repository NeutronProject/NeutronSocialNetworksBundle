<?php
/*
 * This file is part of NeutronSocialNetworksBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\SocialNetworksBundle\Entity\Repository;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class SocialNetworkRepository extends TranslationRepository
{
    public function getSocialLinks()
    {
        return $this->findBy(array('enabled' => true), array('position' => 'ASC'));
    }
    
    public function getQueryBuilderForDataGrid()
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->select('s.id, s.name, s.linkClass, s.enabled')
            ->orderBy('s.position', 'ASC')
        ;
        
        return $qb;
    }
}