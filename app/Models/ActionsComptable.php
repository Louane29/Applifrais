<?php namespace App\Models;

use CodeIgniter\Model;
use \App\Models\DataAccess;
use \DateTime;
use \DateInterval;

/**
 * Modèle représentant tous les traitements possibles attachés à un Visiteur désigné
 *
 */
class ActionsComptable extends Model {

	private $dao;
	private $idComptable;
	 
	function __construct($idComptable)
	{
		// Call the Model constructor
		parent::__construct();

		// chargement du modèle d'accès aux données qui est utile à toutes les méthodes
		$this->dao = new DataAccess();
		$this->idComptable = $idComptable;
	}

	/**
	 * Mécanisme de contrôle d'existence des fiches de frais sur les 6 derniers 
	 * mois pour un visiteur donné. 
	 * Si l'une d'elle est absente, elle est créée.
	 * 
	*/
	public function checkLastSix()
	{	
		// date courante
		$date = new DateTime ("now");
		// interval de 1 mois
		$interval = new DateInterval('P1M');
		
		// Six tours de boucle
		for($i=1; $i<=6; $i++) {
			// la date au format aaaamm
			$unMois = $date->format('Ym');
			// si la fiche pour le mois concerné n'existe pas, ...
			if(!$this->dao->existeFiche($this->idComptable, $unMois)) {
				// ...on la crée
				$this->dao->insertFiche($this->idComptable, $unMois);
			}
			// le mois précédent
			$date->sub($interval);
		}
	}
	
	/**
	 * Liste les fiches existantes d'un visiteur 
	 *
	 * @param $message : message facultatif destiné à notifier l'utilisateur du résultat d'une action précédemment exécutée
	*/
	public function getLesFichesDesVisiteursPourComptable($message=null)
	{		
		return $this->dao->getLesFiches($this->idComptable);
	}	

	/**
	 * Retourne le détail de la fiche sélectionnée 
	 * 
	 * @param $mois : le mois de la fiche à modifier 
	*/
	public function getLaFiche($mois)
	{	
		$res = array();
		
		$res['lesFraisHorsForfait'] = $this->dao->getLesLignesHorsForfait($this->idComptable, $mois);
		$res['lesFraisForfait'] = $this->dao->getLesLignesForfait($this->idComptable, $mois);		
		
		return $res;
	}

	/**
	 * Signe une fiche de frais en modifiant son état de "CR" à "CL"
	 * Ne fait rien si l'état initial n'est pas "CR"
	 * 
	 * @param $mois : le mois de la fiche à signer
	*/
//	public function signeLaFiche($mois)
//	{	// TODO : intégrer une fonctionnalité d'impression PDF de la fiche
//
//		$laFiche = $this->dao->getLaFiche($this->idVisiteur,$mois);
//		if($laFiche['idEtat']=='CR'){
//				$this->dao->updateEtatFiche($this->idVisiteur, $mois,'CL');
//		}
//	}

	
}