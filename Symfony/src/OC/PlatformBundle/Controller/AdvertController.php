<?php
// On se place dans le namespace des contrôleurs de notre bundle :
namespace OC\PlatformBundle\Controller;

// Notre contrôleur va utiliser l'objet Response, il faut donc le définir grâce au use :
use Symfony\Component\HttpFoundation\Response;

// Le nom de notre contrôleur respecte le nom du fichier pour que l'autoload fonctionne :
class AdvertController
{
	// On définit la méthodeindexAction(). N'oubliez pas de mettre le suffixeActionderrière le nom de la méthode :
	public function indexAction()
	{
		// On crée une réponse toute simple. L'argument de l'objet Response est le contenu de la page que vous envoyez au visiteur, ici « Notre propre Hello World ! ». Puis on retourne cet objet :
		return new Response ("Notre propre Hello World !");
	}
}