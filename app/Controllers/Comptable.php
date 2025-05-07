<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use \App\Models\Authentif;
use \App\Models\ActionsComptable;

/**
 * Contrôleur du module VISITEUR de l'application
 */
class Comptable extends BaseController {

	private $authentif;
	private $idComptable;
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
		$this->idComptable = $this->session->get('idUser');
		$this->data['identite'] = $this->session->get('prenom').' '.$this->session->get('nom');
		$this->actComptable = new ActionsComptable($this->idComptable);
	
	}

	/**
	 * Méthode par défaut qui renvoie la page d'acceuil 
	 */
	public function index()
	{
		// envoie de la vue accueil du visiteur
		return view('v_comptableAccueil', $this->data);
	}

	/**
	 * Déconnecte la session
	 */
	public function seDeconnecter()	
	{
		return $this->authentif->deconnecter();
	}

	/**
	 * Affiche le détail d'une fiche de frais du visiteur connecté, en lecture seule
	 *
	 * @param : le mois de la fiche concernée
	 */
	//public function voirLesFiche($mois)
	//{	// TODO : contrôler la validité du mois de la fiche à consulter
	
//		$this->data['fiche'] = $this->actVisiteur->getLaFiche($mois);
//		$this->data['mois'] = $mois;
//		return view('v_visiteurVoirFiche', $this->data);
//            return "gfd";
	//}
        
        public function fichesAValide($message = "")
	{
		$this->data['lesFiches'] = $this->actComptable->getLesFichesAValide();

		return view('v_comptableFichesAValide', $this->data);	
	}
        
         public function validerUnefiche($idVisiteur, $mois){
            
            $this->actComptable->validerLaFiche($idVisiteur, $mois);
            
            $this->data['lesFiches'] = $this->actComptable->getLesFichesAValide();
            return view('v_comptableFichesAValide', $this->data);
        }
        
        public function refuserUnefiche($idVisiteur, $mois){
            
           // Récupérer le motif depuis l'URL
            $motif = $this->request->getGet('motif');

            // Appeler la méthode métier avec le motif
            $this->actComptable->refuserLaFiche($idVisiteur, $mois, $motif);

            // Recharger les fiches
            $this->data['lesFiches'] = $this->actComptable->getLesFichesAValide();

            return view('v_comptableFichesAValide', $this->data);
        }
        
        
        	/**
	 * Affiche le détail d'une fiche de frais du visiteur connecté, en lecture seule
	 *
	 * @param : le mois de la fiche concernée
	 */
	public function suivreFiche($idVisiteur, $mois)
	{	// TODO : contrôler la validité du mois de la fiche à consulter
	
		$this->data['fiche'] = $this->actComptable->getLaFiche($idVisiteur, $mois);
		$this->data['mois'] = $mois;
		return view('v_comptableVoirFiche', $this->data);
	}
       
}