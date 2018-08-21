<?php
// On se place dans le namespace des contrôleurs de notre bundle :
namespace OC\PlatformBundle\Controller;

// Notre contrôleur va utiliser l'objet Response, il faut donc le définir grâce au use :
use Symfony\Component\HttpFoundation\Response;

// Pour accéder aux méthodes de gestion des templates, nous allons faire hériter notre contrôleur du contrôleur de base de Symfony, qui apporte quelques méthodes bien pratiques dont nous nous servirons tout au long de ce cours. 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Le nom de notre contrôleur respecte le nom du fichier pour que l'autoload fonctionne :
class AdvertController extends Controller
{
	// On définit la méthodeindexAction(). N'oubliez pas de mettre le suffixe Action derrière le nom de la méthode :
	public function indexAction()
	{
		// On récupère la vue d'index
		// NomDuBundle:NomDuContrôleur:NomDeLAction
		// $content = $this
		// 	->get('templating')
		// 	->render('OCPlatformBundle:Advert:index.html.twig', array('nom' => 'winzou'));
		// return new Response ($content);

		// On veut avoir l'URL de l'annonce d'id 5.
        $url = $this->get('router')->generate(
            'oc_platform_view', // 1er argument : le nom de la route
            array('id' => 5)    // 2e argument : les valeurs des paramètres
        );
        // $url vaut « /platform/advert/5 »

        return new Response("L'URL de l'annonce d'id 5 est : ".$url);
	}

	public function byebyeAction()
	{
		// On récupère la vue de byebye
		// NomDuBundle:NomDuContrôleur:NomDeLAction
		$content = $this
			->get('templating')
			->render('OCPlatformBundle:Advert:byebye.html.twig', array('nom' => 'Tchao'));
		return new Response ($content);
	}

	// La route fait appel à OCPlatformBundle:Advert:view,
	// on doit donc définir la méthode viewAction.
	// On donne à cette méthode l'argument $id, pour
	// correspondre au paramètre {id} de la route

	public function viewAction($id)

	{
	    // $id vaut 5 si l'on a appelé l'URL /platform/advert/5
	    // Ici, on récupèrera depuis la base de données
	    // l'annonce correspondant à l'id $id.
	    // Puis on passera l'annonce à la vue pour
	    // qu'elle puisse l'afficher
		return new Response("Affichage de l'annonce d'id : ".$id);

	}

	// On récupère tous les paramètres en arguments de la méthode

    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }
}