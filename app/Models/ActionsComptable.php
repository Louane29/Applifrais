<?php namespace App\Models;

use CodeIgniter\Model;
use \App\Models\DataAccess;
use \DateTime;
use \DateInterval;

/**
 * Modèle représentant tous les traitements possibles attachés à un Comptable désigné
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
	 * Liste les fiches existantes d'un visiteur 
	 *
	 * @param $message : message facultatif destiné à notifier l'utilisateur du résultat d'une action précédemment exécutée
	*/
	public function getLesFichesDuVisiteur($message=null)
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
		$res['lesFraisForfait'] = $this->dao->getLesLignesForfait($this->idCommptable, $mois);		
		
		return $res;
	}
        public function validationFiche()
        {
            $res = array();
            
            $res['validerFiche'] = $this->dao->getValiderFiche($this->idComptable);
        }
}
