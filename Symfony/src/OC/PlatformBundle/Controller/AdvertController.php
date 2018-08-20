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
	// On définit la méthodeindexAction(). N'oubliez pas de mettre le suffixeActionderrière le nom de la méthode :
	public function indexAction()
	{
		// On récupère la vue d'index
		// NomDuBundle:NomDuContrôleur:NomDeLAction
		$content = $this
			->get('templating')
			->render('OCPlatformBundle:Advert:index.html.twig', array('nom' => 'winzou'));
		return new Response ($content);
	}
}