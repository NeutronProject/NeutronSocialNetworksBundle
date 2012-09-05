<?php
namespace Neutron\Widget\SocialNetworksBundle\DataGrid;

use Neutron\Widget\SocialNetworksBundle\Model\SocialNetworkManagerInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Doctrine\ORM\Query;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Doctrine\ORM\EntityManager;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class SocialNetworkDataGrid
{

    const IDENTIFIER = 'social_network_management';
    
    protected $factory;

    protected $manager;
    
    protected $translator;
    
    protected $router;
    
    protected $session;
    
    protected $defaultLocale;


    public function __construct (FactoryInterface $factory, SocialNetworkManagerInterface $manager, 
            Translator $translator, Router $router, SessionInterface $session, $defaultLocale)
    {
        $this->factory = $factory;
        $this->manager = $manager;
        $this->translator = $translator;
        $this->router = $router;
        $this->session = $session;
        $this->defaultLocale = $defaultLocale;
    }

    public function build ()
    {
        
        /**
         *
         * @var DataGrid $dataGrid
         */
        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setCaption(
                $this->translator->trans('grid.social_links_management.title',  array(), 'NeutronSocialNetworksBundle')
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.social_links_management.column.name',  array(), 'NeutronSocialLinksBundle'),
                $this->translator->trans('grid.social_links_management.column.linkClass',  array(), 'NeutronSocialLinksBundle'),
                $this->translator->trans('grid.social_links_management.column.enabled',  array(), 'NeutronSocialLinksBundle'),
    
            ))
            ->setColModel(array(
                array(
                    'name' => 's.name', 'index' => 's.name', 'width' => 200, 
                    'align' => 'left', 'sortable' => false, 'search' => true,
                ), 
                array(
                    'name' => 's.linkClass', 'index' => 's.linkClass', 'width' => 200, 
                    'align' => 'left', 'sortable' => false, 'search' => false,
                ),  
                array(
                    'name' => 's.enabled', 'index' => 's.enabled',  'width' => 40, 
                    'align' => 'left',  'sortable' => false, 
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array(
                        'value' => array(
                            1 => $this->translator->trans('grid.enabled', array(), 'NeutronSocialNetworksBundle'), 
                            0 => $this->translator->trans('grid.disabled', array(), 'NeutronSocialNetworksBundle')
                        )
                    )
                ),
    
            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForDataGrid())
            ->enableSortable(true)
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_social_networks.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_social_networks.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_social_networks.delete', array('id' => '{id}'), true))
            ->setQueryHints(array(
                Query::HINT_CUSTOM_OUTPUT_WALKER 
                    => 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker',
                \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE 
                    => $this->session->get('frontend_language', $this->defaultLocale),
            ))
    
            ->setFetchJoinCollection(false)
        ;

        return $dataGrid;
    }


}