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
				$modLink = '';
				$signeLink = '';

				if ($uneFiche['id'] == 'CR') {
					$modLink = anchor('visiteur/modMaFiche/'.$uneFiche['mois'], 'modifier',  'title="Modifier la fiche"');
					$signeLink = anchor('visiteur/signeMaFiche/'.$uneFiche['mois'], 'signer',  'title="Signer la fiche"  onclick="return confirm(\'Voulez-vous vraiment signer cette fiche ?\');"');
				}

				$date = new DateTime($uneFiche['dateModif']);
				echo 
				'<tr>
					<td class="date">'.anchor('visiteur/voirMaFiche/'.$uneFiche['mois'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$date->format('d/m/Y').'</td>
					<td class="action">'.$modLink.'</td>
					<td class="action">'.$signeLink.'</td>
				</tr>';
			}
		?>	  
		</tbody>
    </table>

</div>
<?= $this->endSection() ?>