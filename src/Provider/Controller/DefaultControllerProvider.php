<?php
namespace kids\Provider\Controller;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerProvider implements ControllerProviderInterface
{
	public function connect( Application $app )
	{
		$controller = $app['controllers_factory'];
		$controller->match('/', 'Kids\Controller\DefaultController::indexAction')->bind('homepage');
		$controller->match('/contact', 'Kids\Controller\DefaultController::contactAction')->bind('contact');
		$controller->match('/faq', 'Kids\Controller\DefaultController::faqAction')->bind('faq');

		return $controller;
	}

}
