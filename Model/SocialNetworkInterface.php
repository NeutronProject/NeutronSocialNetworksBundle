<?php
namespace Neutron\Widget\SocialNetworksBundle\Model;

interface SocialNetworkInterface
{
	public function getId ();

	public function getName ();

	public function setName ($name);

	public function getLinkClass ();

	public function setLinkClass ($linkClass);

	public function getLinkUrl ();

	public function setLinkUrl ($linkUrl);

	public function getLinkTarget ();

	public function setLinkTarget ($linkTarget);
	
	public function getPosition();
	
	public function setPosition($position);
	
	public function getEnabled ();

	public function setEnabled ($enabled);
}
