<?php
// On se place dans le namespace des contrôleurs de notre bundle :
namespace OC\PlatformBundle\Controller;

// Notre contrôleur va utiliser l'objet Response, il faut donc le définir grâce au use :
use Symfony\Component\HttpFoundation\Response;
// Idem avec l'objet Request
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Pour accéder aux méthodes de gestion des templates, nous allons faire hériter notre contrôleur du contrôleur de base de Symfony, qui apporte quelques méthodes bien pratiques dont nous nous servirons tout au long de ce cours. 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Le nom de notre contrôleur respecte le nom du fichier pour que l'autoload fonctionne :
class AdvertController extends Controller
{

	 /**
     * @Route("/toto", name="toto")
     */
    public function annotationAction(Request $request)
    {
    	// un "get" old school
        echo $_GET['prenom'];
        // un "get" en Symfony
        echo $request->query->get('prenom');
        // Il faut toujours renvoyer une réponse
        return new Response('test');
        // à tester avecl'adresse http://localhost:8888/projets_symfony/Symfony/web/app_dev.php/platform/toto?prenom=saysa
    }

    /**
    * @Route("/bye", name="oc_platform_bye")
    */
	public function byebyeAction()
	{
		// On récupère la vue de byebye
		// NomDuBundle:NomDuContrôleur:NomDeLAction
		$content = $this
			->get('templating')
			->render('OCPlatformBundle:Advert:byebye.html.twig', array('nom' => 'Tchao'));
		return new Response ($content);
	}

    /**
    * @Route("/{page}", name="oc_platform_home", requirements={"page"="\d*"})
    */
	public function indexAction($page)
	{
        // On ne sait pas combien de pages il y a
    	// Mais on sait qu'une page doit être supérieure ou égale à 1
    	if ($page < 1) {
      	// On déclenche une exception NotFoundHttpException, cela va afficher
      	// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
      	throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    	}

	    // Ici, on récupérera la liste des annonces, puis on la passera au template
	    // Notre liste d'annonce en dur

	    $listAdverts = array(

	      array(
	        'title'   => 'Recherche développpeur Symfony',
	        'id'      => 1,
	        'author'  => 'Alexandre',
	        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
	        'date'    => new \Datetime()
	      ),

	      array(
	        'title'   => 'Mission de webmaster',
	        'id'      => 2,
	        'author'  => 'Hugo',
	        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
	        'date'    => new \Datetime()
	      ),

	      array(
	        'title'   => 'Offre de stage webdesigner',
	        'id'      => 3,
	        'author'  => 'Mathieu',
	        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
	        'date'    => new \Datetime()
	      )
	    );

	    // Et modifiez le 2nd argument pour injecter notre liste
	    $page = 1;
	    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
	      'listAdverts' => $listAdverts
	    ));        
	}

	/**
	// La route fait appel à OCPlatformBundle:Advert:view,
	// on doit donc définir la méthode viewAction.
	// On donne à cette méthode l'argument $id, pour
	// correspondre au paramètre {id} de la route
	// Vous avez accès à la requête HTTP via $request
	// On injecte la requête dans les arguments de la méthode

	* @Route("/advert/{id}", name="oc_platform_view", requirements={"id"= "\d+"} )
	*/
	public function viewAction($id, Request $request)

	{
     	// Ici, on récupérera l'annonce correspondante à l'id $id
	    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
	      'id' => $id
	    ));
	}

    /**
    * @Route("/add", name="oc_platform_add")
    */
	public function addAction(Request $request)

	{
	// La gestion d'un formulaire est particulière, mais l'idée est la suivante :
    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      // Ici, on s'occupera de la création et de la gestion du formulaire
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }

	/**
    * @Route("/edit/{id}", name="oc_platform_edit", requirements={"id"= "\d+"})
    */
	public function editAction(Request $request)

	{
		// Ici, on récupérera l'annonce correspondante à $id

	    // Même mécanisme que pour l'ajout

	    if ($request->isMethod('POST')) {
	    	// Ici, on s'occupera de la création et de la gestion du formulaire
	        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
	        // Puis on redirige vers la page de visualisation de cettte annonce
	        return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    	}
    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('OCPlatformBundle:Advert:edit.html.twig');
    
    }

	/**
    * @Route("/delete/{id}", name="oc_platform_delete", requirements={"id"= "\d+"})
    */
	public function deleteAction(Request $request)

	{
		// Ici, on récupérera l'annonce correspondant à $id

	    // Ici, on gérera la suppression de l'annonce en question

	    return $this->render('OCPlatformBundle:Advert:delete.html.twig');
	    
    }

    public function menuAction($limit)

  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !

    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));

  }
    
}