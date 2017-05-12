<?php
namespace Kids\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Kids\Entity\Workshop;
use Kids\Entity\Establishment;
use Kids\Entity\PublicAge;
use Kids\Entity\WorkshopCategory;

use Kids\Entity\Address;
use Kids\Entity\Kid;
use Kids\Entity\KidHasParent;
use Kids\Entity\ParentOfKid;
use Kids\Entity\WorkshopHasKid;
use Kids\Entity\Timetable;


class WorkshopController
{


  public function indexAction(Application $app, Request $request)
  {
    $workshop = new Workshop();
    $list = $workshop->fetchAll();

    $age = new PublicAge();
    $ages = $age->fetchAll();
    $establishment = new Establishment();
    $establishments = $establishment->fetchAll();

    $categorie = new WorkshopCategory();
    $categories = $categorie->fetchAll();


    return new Response($app['twig']->render('workshop/index.html.twig', array('workshops' => $list,
    'ages' => $ages,
    'lieux' => $establishments,
    'categories' => $categories)));
  }




  public function indexAdminAction(Application $app, Request $request)
  {
    $workshop = new Workshop();
    $list = $workshop->fetchAll(null, false);

    return new Response($app['twig']->render('workshop/index_admin.html.twig', array(
      'workshops' => $list)));
  }


  /**
  * nouveau atelier
  *
  */
  public function newAction(Application $app, Request $request)
  {

    $user = $app['session']->get('user');
    if (empty($user)) {
      return $app->redirect('/login');
    }

    $age = new PublicAge();
    $ages = $age->fetchAll();
    $establishment = new Establishment();
    $establishments = $establishment->fetchAll();

    $workshop = new WorkshopCategory();
    $workshops = $workshop->fetchAll();


    if ($request->isMethod('post')){

      // upload images
      $target_dir = __DIR__.'/../../web/images/';
      $filename = time() . basename($_FILES["fileToUpload"]["name"]);
      $target_file = $target_dir . $filename;
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }

      // Check if file already exists
      if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 9999999) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }

      $workshop = new Workshop();

      if (isset($_POST['visibility']) && $_POST['visibility'] != null) {
        $visibility = 1;
      } else {
        $visibility = 0;
      }
      $workshop
      ->setTitle($_POST['title'])
      ->setDescription($_POST['description'])
      ->setPrice($_POST['price'])
      ->setMaxKids($_POST['max_kids'])
      ->setImage($filename)
      ->setVisible($visibility)
      ->setPublicAgeId($_POST['age'])
      ->setEstablishmentId($_POST['establishment'])
      ->setWorkshopCategoryId($_POST['category']);
      $workshop->save();


      $timetable = new Timetable();

      $date = explode('/', $_POST['debut']);
      $dateFormat = $date[2] . '-' . $date[1] . '-' . $date[0];
      $startAt = $dateFormat . ' ' . $_POST['hours_debut'];
      $endAt = $dateFormat . ' ' . $_POST['hours_fin'];
      $timetable->setStartAt($startAt)
      ->setEndAt($endAt)
      ->setWorkshopId($workshop->getId())
      ->save();

      return $app->redirect('/admin/ateliers');

    }

    return new Response($app['twig']->render('workshop/new.html.twig', array(
      'ages' => $ages,
      'establishments' => $establishments,
      'workshops_category' => $workshops,
    )));
  }


  public function deleteAction(Application $app, Request $request)
  {

    $user = $app['session']->get('user');
    if (empty($user)) {
      return $app->redirect('/login');
    }

    $id = $request->get('id');

    $workshopModel = new Workshop();
    $workshop = $workshopModel->delete($id);

    return $app->redirect('/admin/ateliers');

  }


  public function registerAction(Application $app, Request $request)
  {
    $default = ($request->get('id') != null ? $request->get('id') : null);

    $workshop = new Workshop();
    $list = $workshop->fetchAll();

    if ($request->isMethod('post')){

      $address = new Address();
      $address->setAddress($_POST['adresse'])
      ->setComplement($_POST['complement'])
      ->setCity($_POST['ville'])
      ->setZipcode($_POST['code_postal'])
      ->save();

      $parent = new ParentOfKid();
      $parent->setFirstname($_POST['parent_prenom'])
      ->setLastname($_POST['parent_nom'])
      ->setEmail($_POST['mail'])
      ->setAddressId($address->getId())
      ->setPhone($_POST['telephone'])
      ->save();


      $enfant = new Kid();

      $birthday = explode('/', $_POST['enfant1_naissance']);
      $birthdayFormat = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];

      $enfant->setFirstname($_POST['enfant1_prenom'])
      ->setLastname($_POST['enfant1_nom'])
      ->setBirthday($birthdayFormat)
      ->setClassroom( ($_POST['enfant1_classe'] == '' ? 'NULL' : $_POST['enfant1_classe']))
      ->save();

      $WorkshopHasKid = new WorkshopHasKid();
      $WorkshopHasKid->setWorkshopId($_POST['ateliers'])
      ->setKidId($enfant->getId())
      ->save();

      $kidHasParent = new KidHasParent();
      $kidHasParent->setKidId($enfant->getId())
      ->setParentId($parent->getId())
      ->save();


      if ($_POST['enfant2_nom'] != ''
      && $_POST['enfant2_prenom'] != ''
      && $_POST['enfant2_naissance'] != '') {

        $enfant = new Kid();
        $birthday = explode('/', $_POST['enfant2_naissance']);
        $birthdayFormat = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];

        $enfant->setFirstname($_POST['enfant2_prenom'])
        ->setLastname($_POST['enfant2_nom'])
        ->setBirthday($birthdayFormat)
        ->setClassroom( ($_POST['enfant2_classe'] == '' ? 'NULL' : $_POST['enfant2_classe']))
        ->save();

        $WorkshopHasKid = new WorkshopHasKid();
        $WorkshopHasKid->setWorkshopId($_POST['ateliers'])
        ->setKidId($enfant->getId())
        ->save();

        $kidHasParent = new KidHasParent();
        $kidHasParent->setKidId($enfant->getId())
        ->setParentId($parent->getId())
        ->save();

      }

      $app['session']->getFlashBag()->add('message', 'Votre inscription a bien été enregistrer.');
      return $app->redirect('/ateliers');

    }

    return new Response($app['twig']->render('workshop/register.html.twig', array('workshops' => $list, 'default' => $default)));
  }


  public function attenteAdminAction(Application $app, Request $request)
  {

    $user = $app['session']->get('user');
    if (empty($user)) {
      return $app->redirect('/login');
    }

    $workshop = new WorkshopHasKid();
    $list = $workshop->fetchAll();

    if ($request->get('workshop') != NULL && $request->get('response') != NULL && $request->get('kid') != NULL) {

      $workshop->edit($request->get('response'), $request->get('workshop'), $request->get('kid'));
      return $app->redirect('/ateliers/attente');

    }

    return new Response($app['twig']->render('workshop/attente.html.twig', array('workshops' => $list)));
  }


}
