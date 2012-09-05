<?php
/*
 * This file is part of NeutronSocialNetworksBundle
*
* (c) Zender <azazen09@gmail.com>
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/
namespace Neutron\Widget\SocialNetworksBundle\Entity;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass 
 */
abstract class SocialNetwork implements SocialNetworkInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string 
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="name", length=255, nullable=false, unique=false)
     */
    protected $name;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="link_class", length=30, nullable=true, unique=false)
     */
    protected $linkClass;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="link_url", length=255, nullable=false, unique=false)
     */
    protected $linkUrl;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="link_target", length=10, nullable=true, unique=false)
     */
    protected $linkTarget;
    
    /**
     * @var integer
     * 
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", name="position", length=10, nullable=false, unique=false)
     */
    protected $position;
    
    /**
     * @Gedmo\SortableGroup
     * @ORM\Column(name="sortable_category", type="string", length=128, nullable=true)
     */
    private $sortableCategory;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;
    
	public function getId ()
    {
        return $this->id;
    }

	public function getName ()
    {
        return $this->name;
    }

	public function setName ($name)
    {
        $this->name = $name;
    }

	public function getLinkClass ()
    {
        return $this->linkClass;
    }

	public function setLinkClass ($linkClass)
    {
        $this->linkClass = $linkClass;
    }

	public function getLinkUrl ()
    {
        return $this->linkUrl;
    }

	public function setLinkUrl ($linkUrl)
    {
        $this->linkUrl = $linkUrl;
    }

	public function getLinkTarget ()
    {
        return $this->linkTarget;
    }

	public function setLinkTarget ($linkTarget)
    {
        $this->linkTarget = $linkTarget;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function setSortableCategory($sortableCategory)
    {
        $this->sortableCategory = $sortableCategory;
    }
    
    public function getSortableCategory()
    {
        return $this->sortableCategory;
    }

	public function setEnabled ($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getEnabled ()
    {
        return $this->enabled;
    }
    
}