<?php
// On se place dans le namespace des contrôleurs de notre bundle :
namespace OC\PlatformBundle\Controller;

// Notre contrôleur va utiliser l'objet Response, il faut donc le définir grâce au use :
use Symfony\Component\HttpFoundation\Response;
// Idem avec l'objet Request
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    * @Route("/{page}", name="oc_platform_home", requirements={"page"="\d*"})
    */
	// On définit la méthodeindexAction(). N'oubliez pas de mettre le suffixe Action derrière le nom de la méthode :
	public function indexAction()
	{
		// On récupère la vue d'index
		// NomDuBundle:NomDuContrôleur:NomDeLAction
		// $content = $this
		// 	->get('templating')
		// 	->render('OCPlatformBundle:Advert:index.html.twig', arexray('nom' => 'winzou'));
		// return new Response ($content);

		// On veut avoir l'URL de l'annonce d'id 5.
        $url = $this->get('router')->generate(
            'oc_platform_view', // 1er argument : le nom de la route
            array('id' => 5)    // 2e argument : les valeurs des paramètres
        );
        // $url vaut « /platform/advert/5 »

        return new Response("L'URL de l'annonce d'id 5 est : ".$url);
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
	// La route fait appel à OCPlatformBundle:Advert:view,
	// on doit donc définir la méthode viewAction.
	// On donne à cette méthode l'argument $id, pour
	// correspondre au paramètre {id} de la route
	// Vous avez accès à la requête HTTP via $request
	// On injecte la requête dans les arguments de la méthode

	* @Route("/advert/{id}", name="oc_platform_view", requirements={"id"= "\d+"} )
	* @param $id
	* @param Request $request
	*
	* @return Response

	*/
	public function viewAction($id, Request $request)

	{
	    // $id vaut 5 si l'on a appelé l'URL /platform/advert/5
	    // Ici, on récupèrera depuis la base de données
	    // l'annonce correspondant à l'id $id.
	    // Puis on passera l'annonce à la vue pour
	    // qu'elle puisse l'afficher

	    // On récupère notre paramètre tag
    	$tag = $request->query->get('tag');

    	return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      		'id'  => $id,
      		'tag' => $tag,
      	));
     	// A tester avec l'adresse http://localhost:8888/projets_symfony/Symfony/web/app_dev.php/platform/advert/5?tag=developer
	}

	// On récupère tous les paramètres en arguments de la méthode

	/**
    * @Route("/viewslug", name="oc_platform_viewslug")
    */
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }

    
}