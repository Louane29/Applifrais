<?= $this->extend('l_comptable') ?>

<?= $this->section('body') ?>
<div id="contenu">
    <h2>Liste des fiches de frais à valider</h2>
     
    <?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
 
    <table class="listeLegere">
        <thead>
            <tr>
                <th>Id Visiteur</th>  <!-- Nouvelle colonne pour l'ID du visiteur -->
                <th>Mois</th>
                <th>Etat</th>  
                <th>Montant</th>  
                <th>Date modif.</th>  
                <th colspan="4">Actions</th>              
            </tr>
        </thead>
        <tbody>
          
        <?php    
            foreach($lesFiches as $uneFiche) 
            {
                $modLink = '';
                $signeLink = '';

                // Logique pour les actions (Refuser et Valider)
                if ($uneFiche['id'] == 'CL') {
                    $modLink = '
                            <form method="get" action="'.site_url('comptable/refuserUneFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois']).'">
                                <input type="text" name="motif" placeholder="Motif de refus" required style="width: 150px;" />
                                <input type="submit" value="Refuser" />
                            </form>';
                    
                    $signeLink = anchor('comptable/validerUneFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois'], 'Valider', 'title="Signer la fiche"  onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');
                }

                $date = new DateTime($uneFiche['dateModif']);
                echo 
                '<tr>
                    <td class="idVisiteur">'.$uneFiche['idVisiteur'].'</td>
                    <td class="date">'.anchor('comptable/suivreFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois'], $uneFiche['mois'], 'title="Consulter la fiche"').'</td>
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