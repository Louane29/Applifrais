<?= $this->extend('l_comptable') ?>

<?= $this->section('body') ?>
<div id="contenu">
	<h2>Liste des fiches de frais des visiteurs</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >??</th>
				<th >Visiteurs</th>  
				<th >??</th>  
				<th >Date de signature</th>  
				<th  colspan="4">??</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach($mesFiches as $uneFiche) 
			{
				$validLink = '';
				$denyLink = '';

				if ($uneFiche['id'] == 'CL') {
					$validLink = anchor('visiteur/modMaFiche/'.$uneFiche['mois'], 'Valider', 'title="Valider la fiche" onclick="return confirm(\'Voulez-vous vraiment VALIDER cette fiche ?\');"');
					$denyLink = anchor('visiteur/signeMaFiche/'.$uneFiche['mois'],'Refuser',  'title="Refuser la fiche"  onclick="return confirm(\'Voulez-vous vraiment REFUSER cette fiche ?\');"');
				}

				$date = new DateTime($uneFiche['dateModif']);
				echo 
				'<tr>
					<td class="date">'.anchor('visiteur/voirMaFiche/'.$uneFiche['mois'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$date->format('d/m/Y').'</td>
					<td class="action">'.$validLink.'</td>
					<td class="action">'.$denyLink.'</td>
				</tr>';
			}
		?>	  
		</tbody>
    </table>

</div>
<?= $this->endSection() ?>