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
    * @Route("/viewslug", name="oc_platform_viewslug")
    */
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }

    /**
    * @Route("/{page}", name="oc_platform_home", requirements={"page"="\d*"})
    */
	// On définit la méthodeindexAction(). N'oubliez pas de mettre le suffixe Action derrière le nom de la méthode :
	public function indexAction($page)
	{
		// On récupère la vue d'index
		// NomDuBundle:NomDuContrôleur:NomDeLAction
		// $content = $this
		// 	->get('templating')
		// 	->render('OCPlatformBundle:Advert:index.html.twig', array('nom' => 'winzou'));
		// return new Response ($content);

		// On veut avoir l'URL de l'annonce d'id 5.
        // $url = $this->get('router')->generate(
        //     'oc_platform_view', // 1er argument : le nom de la route
        //     array('id' => 5)    // 2e argument : les valeurs des paramètres
        // );
        // $url vaut « /platform/advert/5 »
        // return new Response("L'URL de l'annonce d'id 5 est : ".$url);

        // On ne sait pas combien de pages il y a
    	// Mais on sait qu'une page doit être supérieure ou égale à 1
    	if ($page < 1) {
      	// On déclenche une exception NotFoundHttpException, cela va afficher
      	// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
      	throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    	}

	    // Ici, on récupérera la liste des annonces, puis on la passera au template

	    // Mais pour l'instant, on ne fait qu'appeler le template
	    return $this->render('OCPlatformBundle:Advert:index.html.twig');
        
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
	    // $id vaut 5 si l'on a appelé l'URL /platform/advert/5
	    // Ici, on récupèrera depuis la base de données
	    // l'annonce correspondant à l'id $id.
	    // Puis on passera l'annonce à la vue pour
	    // qu'elle puisse l'afficher

	    // On récupère notre paramètre tag
    	// $tag = $request->query->get('tag');

    	// return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
	    //  		'id'  => $id,
	    //  		'tag' => $tag,
	    //  	));
     	// A tester avec l'adresse http://localhost:8888/projets_symfony/Symfony/web/app_dev.php/platform/advert/5?tag=developer

     	// testons les redirections :
     	// return $this->redirectToRoute('oc_platform_home');

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
    // $session = $request->getSession();
    // // Bien sûr, cette méthode devra réellement ajouter l'annonce
    // // Mais faisons comme si c'était le cas

    // $session->getFlashBag()->add('info', 'Annonce bien enregistrée');
    // // Le « flashBag » est ce qui contient les messages flash dans la session
    // // Il peut bien sûr contenir plusieurs messages :
    // $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');
    // // Puis on redirige vers la page de visualisation de cette annonce
    // return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    
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

    public function menuAction()

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