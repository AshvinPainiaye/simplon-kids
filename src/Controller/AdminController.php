<?php
namespace Kids\Controller;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Kids\Entity\Admin;

class AdminController
{

  /**
  * accueil admin
  *
  */
  public function indexAction(Application $app, Request $request)
  {
    $user = $app['session']->get('user');
    if ($user != null) {

      return new Response($app['twig']->render('admin/index.html.twig', array(
        'users' => $user
      )));
    } else {
      return $app->redirect('/login');
    }
  }


  public function loginAction(Application $app, Request $request)
  {

    if ($request->isMethod('post')){

      $username = $_POST['username'];
      $password = sha1($_POST['password']);

      $admin = new Admin();
      $authenticate = $admin->authenticate($username, $password);

      if ($authenticate) {
        $app['session']->set('user', $authenticate);
        return $app->redirect('/admin');
      }

      $app['session']->getFlashBag()->add('message', 'Email ou Mot de passe incorrect.');
      return $app->redirect('/login');
    }

    return new Response($app['twig']->render('login.html.twig'));
  }


  public function logoutAction(Application $app, Request $request)
  {
    $app['session']->clear();
    return $app->redirect('/');

  }


}
