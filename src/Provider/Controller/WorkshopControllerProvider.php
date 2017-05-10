<?php
namespace kids\Provider\Controller;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkshopControllerProvider implements ControllerProviderInterface
{
	public function connect( Application $app )
	{
		$controller = $app['controllers_factory'];
		$controller->match('/ateliers', 'kids\Controller\WorkshopController::indexAction')->bind('workshop');
		$controller->match('/ateliers/new', 'kids\Controller\WorkshopController::newAction')->bind('new_workshop');
		$controller->match('/ateliers/details/{id}', 'kids\Controller\WorkshopController::viewAction')->bind('view_workshop');
		$controller->match('/ateliers/inscription', 'kids\Controller\WorkshopController::registerAction')->bind('workshop_register');
		$controller->match('/ateliers/inscription/{id}', 'kids\Controller\WorkshopController::registerAction')->bind('workshop_register_id');
		$controller->match('/ateliers/attente', 'kids\Controller\WorkshopController::attenteAdminAction')->bind('workshop_attente_admin');
		$controller->match('/ateliers/attente/{workshop}/{kid}/{response}', 'kids\Controller\WorkshopController::attenteAdminAction')->bind('workshop_attente_admin_response');


		return $controller;
	}

}
