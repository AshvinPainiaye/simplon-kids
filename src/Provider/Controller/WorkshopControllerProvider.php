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
		$controller->match('/ateliers', 'Kids\Controller\WorkshopController::indexAction')->bind('workshop');
		$controller->match('/ateliers/new', 'Kids\Controller\WorkshopController::newAction')->bind('new_workshop');
		$controller->match('/ateliers/inscription', 'Kids\Controller\WorkshopController::registerAction')->bind('workshop_register');
		$controller->match('/ateliers/inscription/{id}', 'Kids\Controller\WorkshopController::registerAction')->bind('workshop_register_id');
		$controller->match('/ateliers/attente', 'Kids\Controller\WorkshopController::attenteAdminAction')->bind('workshop_attente_admin');
		$controller->match('/ateliers/attente/{workshop}/{kid}/{response}', 'Kids\Controller\WorkshopController::attenteAdminAction')->bind('workshop_attente_admin_response');
		$controller->match('/admin/ateliers', 'Kids\Controller\WorkshopController::indexAdminAction')->bind('workshop_index_admin');
		$controller->match('/admin/ateliers/delete/{id}', 'Kids\Controller\WorkshopController::deleteAction')->bind('workshop_delete');


		return $controller;
	}

}
