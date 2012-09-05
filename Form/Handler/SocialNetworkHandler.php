<?php
namespace Neutron\Widget\SocialNetworksBundle\Form\Handler;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

use Symfony\Component\Translation\TranslatorInterface;

use Neutron\ComponentBundle\Form\Handler\FormHandlerInterface;

use Neutron\ComponentBundle\Form\Helper\FormHelper;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Form;

use Symfony\Component\HttpFoundation\Request;

class SocialNetworkHandler implements FormHandlerInterface
{
    
    protected $request;
    
    protected $router;
    
    protected $translator;
    
    protected $form;
    
    protected $formHelper;
    
    protected $socialNetworkManager;

    protected $result;


    public function __construct(Form $form, FormHelper $formHelper, Request $request, Router $router, 
            TranslatorInterface $translator, SocialNetworkManagerInterface $socialNetworkManager)
    {
        $this->form = $form;
        $this->formHelper = $formHelper;
        $this->request = $request;
        $this->router = $router;
        $this->translator = $translator;
        $this->socialNetworkManager = $socialNetworkManager;
    }

    public function process()
    {
        if ($this->request->isXmlHttpRequest()) {
            
            $this->form->bind($this->request);
 
            if ($this->form->isValid()) {
                
                $this->onSucess();
                
                $this->request->getSession()
                    ->getFlashBag()->add('neutron.form.success', array(
                        'type' => 'success',
                        'body' => $this->translator->trans('form.success', array(), 'NeutronSocialNetworksBundle')
                    ));
                
                $this->result = array(
                    'success' => true,
                    'redirect_uri' => 
                        $this->router->generate('neutron_social_networks.administration')
                );
                
                return true;
  
            } else {
                $this->result = array(
                    'success' => false,
                    'errors' => $this->formHelper->getErrorMessages($this->form, 'NeutronSocialNetworkBundle')
                );
                
                return false;
            }
  
        }
    }
    
    protected function onSucess()
    {
        $socialNetwork = $this->form->get('general')->getData();
        $this->socialNetworkManager->update($socialNetwork);        
    }
    
    public function getResult()
    {
        return $this->result;
    }

   
}
