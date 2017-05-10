<?php
namespace kids\Provider\Controller;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerProvider implements ControllerProviderInterface
{
	public function connect( Application $app )
	{
		$controller = $app['controllers_factory'];
		$controller->match('/admin', 'kids\Controller\AdminController::indexAction')->bind('admin');
		$controller->match('/login', 'kids\Controller\AdminController::loginAction')->bind('login');
		$controller->match('/logout', 'kids\Controller\AdminController::logoutAction')->bind('logout');


		return $controller;
	}

}
