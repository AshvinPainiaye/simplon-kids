<?php
namespace kids\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use kids\Entity\Workshop;

class DefaultController
{

  /**
  * Accueil du site
  *
  */
  public function indexAction(Application $app, Request $request)
  {
    $workshop = new Workshop();
    $list = $workshop->fetchAll(4);
    return new Response($app['twig']->render('index.html.twig', array('workshops' => $list)));
  }

  /**
  * faq
  *
  */
  public function faqAction(Application $app, Request $request)
  {
    return new Response($app['twig']->render('faq.html.twig'));
  }

  /**
  * Contact
  *
  */
  public function contactAction(Application $app, Request $request)
  {
    return new Response($app['twig']->render('contact.html.twig'));
  }

}
