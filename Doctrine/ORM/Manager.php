<?php
namespace Neutron\Widget\SocialNetworksBundle\Doctrine\ORM;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkInterface;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Translation\TranslatorInterface;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

class Manager implements SocialNetworkManagerInterface
{
    protected $em;
    
    protected $repository;
    
    protected $meta;
    
    protected $className;
    
    protected $translator;
    
    public function __construct(EntityManager $em, $className, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository($className);
        $this->meta = $this->em->getClassMetadata($className);
        $this->className = $this->meta->name;
        $this->translator = $translator;
    }
    
    public function has($identifier)
    {
        $instances = $this->getInstances(null);
        return isset($instances[$identifier]);
    }
    
    public function get($identifier)
    {
        if (!$this->has($identifier)){
            throw new \InvalidArgumentException(
                sprintf('Item with identifier "%s" does not exist.', $identifier)
            );
        }
        
        return $this;
    }
    
    public function getInstances($locale)
    {
        return array($this->getIdentifier() => array(
            'identifier' => $this->getIdentifier(), 
            'label' => $this->getLabel()
        ));
    }
    
    public function getIdentifier()
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
    
    public function create()
    {
        $class = $this->className;
        return new $class();
    }
    
    public function update(SocialNetworkInterface $entity, $andFlush = true)
    {
        $this->em->persist($entity);
        
        if ($andFlush){
            $this->em->flush();
        }     
    }
    
    public function delete(SocialNetworkInterface $entity, $andFlush = true)
    {
        $this->em->remove($entity);
        
        if ($andFlush){
            $this->em->flush();
        }
    }
    
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    public function changePosition(SocialNetworkInterface $entity, $position, $andFlush = true)
    {
        $entity->setPosition($position);
        
        if ($andFlush){
            $this->em->flush();
            $this->em->clear();
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