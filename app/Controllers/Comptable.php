<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use \App\Models\Authentif;
use \App\Models\ActionsVisiteur;

/**
 * Contrôleur du module VISITEUR de l'application
 */
class Comptable extends BaseController {

	private $authentif;
	private $idCompatble;
	private $data;
	private $actComptable;
   
	/**
	 * Constructeur du contrôleur : constructeur fourni par CodeIgniter. S'exécute après le 
	 * constructeur PHP __construct
	 *
	 * Note 1 : Aurait pu être utilisé pour empêcher l'accès aux non-visiteurs mais un constructeur 
	 * 					ne permet pas de renvoyer une vue. Donc pas de vue "erreur" et pas de vue 
	 * 					"connexion" non plus. 
	 * Note 2 : L'interdiction d'accès à ce contrôleur pour les non-visiteurs est opérée par le 
	 * 					biais de "Controller filters" (voir app/Filters/VisiteurFilter.php et 
	 * 					app/Config/Filters.php)
	 */
	public function initController(RequestInterface $request, ResponseInterface $response,
			LoggerInterface $logger ) {
				
		parent::initController($request, $response, $logger);

		// Initialisation des attributs de la classe
		$this->authentif = new Authentif();
		$this->session = session();
		$this->idCompatble = $this->session->get('idUser');
		$this->data['identite'] = $this->session->get('prenom').' '.$this->session->get('nom');
		$this->actComptable = new ActionsComptable($this->idCompatble);

		// Vérification de la présence des 6 dernières fiches de frais pour le visiteur connecté
		$this->actVisiteur->checkLastSix();
	}

	/**
	 * Méthode par défaut qui renvoie la page d'acceuil 
	 */
	public function index()
	{
		// envoie de la vue accueil du comptable
		return view('v_comptableAccueil', $this->data);
	}

	/**
	 * Restitue les liste des fiches du visiteur connecté, sans détails
	 */ 
	public function  mesFiches($message = "")
	{
		$this->data['mesFiches'] = $this->actVisiteur->getLesFichesDuVisiteur();
		$this->data['notify'] = $message;

		return view('v_visiteurMesFiches', $this->data);	
	}

	/**
	 * Déconnecte la session
	 */
	public function seDeconnecter()	
	{
		return $this->authentif->deconnecter();
	}
}