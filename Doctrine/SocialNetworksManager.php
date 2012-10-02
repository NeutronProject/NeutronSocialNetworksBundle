<?php
namespace Neutron\Widget\SocialNetworksBundle\Doctrine;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkInterface;

use Symfony\Component\Translation\TranslatorInterface;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class SocialNetworksManager extends AbstractManager implements SocialNetworkManagerInterface
{

    protected $translator;
    
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    public function has($id)
    {
        $instances = $this->getInstances(null);
        return isset($instances[$identifier]);
    }
    
    public function get($id)
    {
        if (!$this->has($id)){
            throw new \InvalidArgumentException(
                sprintf('Item with id "%s" does not exist.', $id)
            );
        }
        
        return $this;
    }
    
    public function getInstances($locale)
    {
        return array($this->getId() => array(
            'id'    => $this->getId(), 
            'label' => $this->getLabel()
        ));
    }
    
    public function getId()
    {
        return 'standard';
    }
    
    public function getLabel()
    {
        return $this->translator->trans('block.title', array(), 'NeutronSocialNetworksBundle');
    }
    
    public function getSocialLinks()
    {
        return $this->repository->getSocialLinks();
    }
    
    public function getQueryBuilderForDataGrid()
    {
        return $this->repository->getQueryBuilderForDataGrid();
    }

    public function changePosition(SocialNetworkInterface $entity, $position, $andFlush = true)
    {
        $entity->setPosition($position);
        
        if ($andFlush){
            $this->om->flush();
            $this->om->clear();
        }
    }
    
    public function getLinkClasses()
    {
        return array(
            'rss' => 'class.rss',
            'twitter' => 'class.twitter',
            'facebook' => 'class.facebook',
            'flickr' => 'class.flickr',
            'youtube' => 'class.youtube',
            'delicious' => 'class.delicious',
            'digg' => 'class.digg',
        );
    }
}