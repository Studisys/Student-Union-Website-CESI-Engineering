<?php
if(!isset($_SESSION))
    session_start();
include("../scripts/setConnexionLocalBDD.php"); 
if(isset($_POST['id'])){
    if(isset($_POST['l_inscrits'])) {
        include('../events_to_come/registered_list.php');
        $id_users_event = array();
        $participants_evenements = $local_bdd->query('call orleans_bde.sps_participant_evenement(' . $_POST['id'] . ');');

        while ($participant_evenement = $participants_evenements->fetch()) {
            $id_users_event[] = $participant_evenement['Id_utilisateur'];
        }
        $participants_evenements->closeCursor();

        $prenom = array();
        $nom = array();
        $email = array();

        foreach ($id_users_event as $id_user_event) {
            $query = $local_bdd->query('call orleans_bde.sps_user(' . $id_user_event . ');');
            $utilisateur = $query->fetch();
            $prenom[] = $utilisateur['Prenom'];
            $nom[] = $utilisateur['Nom'];
            $email[] = $utilisateur['Email'];

            $query->closeCursor();
        }

        array_to_csv_download(array(
            $prenom, // this array is going to be the first row
            $nom,
            $email), // this array is going to be the second row
            "l_inscrits.csv"
        );
        exit();
    } else if(isset($_POST['l_inscrits_pdf'])) {
        include("../scripts/pdf_l_inscrit.php");
    } else if(isset($_POST['delete'])){
        if(isset($_SESSION['id'])){
            $query = $local_bdd->query('call orleans_bde.spl_photo_by_evenement('.$_POST['id'].');');
            $photos_id = array();
            while($photo=$query->fetch()){
                $photos_id[] = $photo;
            }
            $query->closeCursor();

            foreach($photos_id as $photo_id){
                $local_bdd->query('call orleans_bde.spd_commentaire_by_id_photo('.$photo_id['Id_photo'].');');
                $local_bdd->query('call orleans_bde.spd_likephoto_by_id_photo('.$photo_id['Id_photo'].');');
                $local_bdd->query('call orleans_bde.spd_photo_by_id('.$photo_id['Id_photo'].');');
            }
            $local_bdd->query('call orleans_bde.spd_voteidea_by_evenement('.$_POST['id'].');');
            $local_bdd->query('call orleans_bde.spd_evenement_by_id('.$_POST['id'].');');
        }
        $_POST['delete'] = NULL;
    } else if(isset($_POST['private'])){
        $query= $local_bdd->query('call orleans_bde.spe_evenement_status('.$_POST['id'].');');
        $query = $local_bdd->query('call orleans_bde.sps_event('.$_POST['id'].');');
        $event = $query->fetch();
        $query->closeCursor();

        if($event['Id_status_accessibilite']==4) {
            $query = $local_bdd->query('call orleans_bde.sps_user('.$event['Id_utilisateur'].');');
            $user = $query->fetch();
            $query->closeCursor();
            // mail($user['Email'],"Evénement privé","Votre évenement à été mis en privé par un administrateur, 
            // car son contenu a été jugé offensant ou restrictif.");
        }
        $_POST['private'] = NULL;

    }
    $_POST['id'] = NULL;
}
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>BDE CESI Exia</title>
        
        <?php $PAGE = "Événements passés" ?>
	</head>

	<body class="common-background-white">
        <?php 
        include("../common/header.php");
        include("../idea_box/BandeauSubmitIdea.php"); ?>

        <?php        
        //$_SESSION['status']="Eleve";
        if(isset($_SESSION['status'])){
            if($_SESSION['status']=="Personnel CESI" || $_SESSION['status']=="Membre BDE") {
                $events = $local_bdd->query('call orleans_bde.spl_evenement_passed();');
            }else {
                $events = $local_bdd->query('call orleans_bde.spl_evenement_passed_public();'); 
            }
        } else {
            $events = $local_bdd->query('call orleans_bde.spl_evenement_passed_public();'); 
        }
        $id_events = array();
        while($datasEvent = $events->fetch()){
            $id_events[] = $datasEvent['Id_evenement'];
        }

        $events->closeCursor();
        
        $evenement_du_mois = 1;
        foreach ($id_events as $id_event){
            if($evenement_du_mois <=3){
                echo '<div class="text-center font-weight-bold"><i class="fas fa-medal"></i>Evénement du mois</div>';
                $evenement_du_mois += 1;
            }
            include("../events_passed/event.php");
            echo '<hr class="common-separator2">';
        }

        ?>

		<?php include("../common/footer.php") ?>
		
	</body>
</html>
