<?= $this->extend('l_comptable') ?>

<?= $this->section('body') ?>
<div id="contenu">
	<h2>Gestion des fiches frais des visiteurs</h2>
	<p>Bienvenue dans votre application de gestion des fiches frais de déplacements des visiteurs. </p>
	<p>
		En tant que comptable vous pouvez suivre le paiement des fiches de frais et accepter ou refuser les fiches de frais des visiteurs.
                <br>
		Au moyen du bandeau gauche, vous avez accès aux fonctionalités 
		du profil comptable : 
		<ul>
			<li>Valider les fiches de frais des visiteurs</li>
                        <li>Suivre le paiement des fiches de frais</li>
			<li>Se déconnecter</li>
		</ul>
	</p>
</div>
<?= $this->endSection() ?>