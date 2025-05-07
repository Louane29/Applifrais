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
        
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

		// chargement du modèle d'accès aux données qui est utile à toutes les méthodes
		$this->dao = new DataAccess();
	}

		
	/**
	 * Liste les fiches existantes d'un visiteur 
	 *
	 * @param $message : message facultatif destiné à notifier l'utilisateur du résultat d'une action précédemment exécutée
	*/
	public function getLesFichesAValide($message=null)
	{		
		return $this->dao->getLesFichesSigner();
	}	
        
        
        /**
	 * Retourne le détail de la fiche sélectionnée 
	 * 
	 * @param $mois : le mois de la fiche à modifier 
	*/
	public function getLaFiche($idVisiteur, $mois)
	{	
		$res = array();
		
		$res['lesFraisHorsForfait'] = $this->dao->getLesLignesHorsForfait($idVisiteur, $mois);
		$res['lesFraisForfait'] = $this->dao->getLesLignesForfait($idVisiteur, $mois);		
		
		return $res;
	}

	/**
	 * Valide une fiche de frais en modifiant son état de "CL" à "VA"
	 * Ne fait rien si l'état initial n'est pas "CL"
	 * 
	 * @param $mois : le mois de la fiche à signer
	*/
	public function validerLaFiche($idVisiteur, $mois)
	{	// TODO : intégrer une fonctionnalité d'impression PDF de la fiche               
		$laFiche = $this->dao->getLaFiche($idVisiteur,$mois);
		if($laFiche['idEtat']=='CL'){
                    $this->dao->updateEtatFiche($idVisiteur, $mois,'VA');
                                
		}
	}
        
        /**
	 * Refuse une fiche de frais en modifiant son état de "CL" à "RF"
	 * Ne fait rien si l'état initial n'est pas "CL"
	 * 
	 * @param $mois : le mois de la fiche à signer
	*/
       public function refuserLaFiche($idVisiteur, $mois, $motif)
        {
            $laFiche = $this->dao->getLaFiche($idVisiteur, $mois);
            if ($laFiche['idEtat'] == 'CL') {
                // Met à jour l'état de la fiche
                $this->dao->updateEtatFiche($idVisiteur, $mois, 'RF');

                // Enregistre le motif du refus
                $this->dao->updateMotifRefus($idVisiteur, $mois, $motif);
            }
        }
        

	/**
	 * Modifie les quantités associées aux frais forfaitisés dans une fiche donnée
	 * 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function updateForfait($mois, $lesQtes)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider les données contenues dans $lesFrais ...
		
		$this->dao->updateLignesForfait($this->idVisiteur,$mois,$lesQtes);
		$this->dao->updateMontantFiche($this->idVisiteur,$mois);
	}
      
}