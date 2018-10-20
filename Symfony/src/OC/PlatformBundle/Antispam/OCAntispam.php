<?php

namespace OC\PlatformBundle\Antispam;

class OCAntispam

{
	/**
	   * Vérifie si le texte est un spam ou non
	   *
	   * @param string $text
	   * @return bool
	   */

	public function isSpam($text)
	{ 
		// c'est un boléen, ça va retourner true ou false :
	    return strlen($text) < 50;
	}
}