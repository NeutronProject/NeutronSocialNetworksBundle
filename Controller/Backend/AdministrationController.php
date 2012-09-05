<?php
namespace Neutron\Widget\SocialNetworksBundle\Controller\Backend;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkInterface;

use Neutron\ComponentBundle\Form\Handler\FormHandlerInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class AdministrationController extends ContainerAware
{
    
    public function indexAction()
    {    
        
        $grid = $this->container->get('neutron.datagrid')->get(
            $this->container->getParameter('neutron_social_networks.grid')
        );
        
        $template = $this->container->get('templating')
            ->render('NeutronSocialNetworksBundle:Backend\Administration:index.html.twig', array(
                'grid' => $grid   
            )
        );
    
        return  new Response($template);
    }
    
    public function updateAction($id)
    {
        
        $form = $this->container->get('neutron_social_networks.form.social_network');
        $handler = $this->container->get('neutron_social_networks.form.handler.social_network');
        
        $form->setData($this->getData($id));
        
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
        
        $template = $this->container->get('templating')
            ->render('NeutronSocialNetworksBundle:Backend\Administration:update.html.twig', array(
                'form' => $form->createView()
            )
        );
        
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {

        $socialNetwork = $this->getSocialNetwork($id);
        
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->doDelete($socialNetwork);
            
            $this->container->get('session')
               ->getFlashBag()->add('neutron.form.success', array(
                    'type' => 'success',
                    'body' => $this->container->get('translator')
                       ->trans('flash.deleted', array(), 'NeutronSocialNetworksBundle')
                )
            );
            
            $redirectUrl = $this->container->get('router')->generate('neutron_social_networks.administration');
            return new RedirectResponse($redirectUrl);
        }
        
        $template = $this->container->get('templating')
            ->render('NeutronSocialNetworksBundle:Backend\Administration:delete.html.twig', array(
                'record' => $socialNetwork
            )
        );
        
        return  new Response($template);
    }
    
    protected function getSocialNetwork($id)
    {
        $manager = $this->container->get('neutron_social_networks.manager');
        
        if (!$id){
            $socialNetwork = $manager->create();
        } else {
            $socialNetwork = $manager->findOneBy(array('id' => $id));
        }
        
        if (!$socialNetwork instanceof SocialNetworkInterface){
            throw new NotFoundHttpException();
        }
        
        return $socialNetwork;
    }
    
    protected function getData($id)
    {
        return array('general' => $this->getSocialNetwork($id));
    }
    
    protected function doDelete(SocialNetworkInterface $socialNetwork)
    {
        $manager = $this->container->get('neutron_social_networks.manager');
        $manager->delete($socialNetwork);
    }
    

}
