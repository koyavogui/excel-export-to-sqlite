<?php
    $db = new PDO('sqlite:../database/devoir.db');
    if (!empty($_POST)  AND isset($_POST['nom'])) {
        $stmt_personnes = $db->prepare("INSERT INTO personnes (idCentre, nom, prenom) VALUES (:idcentre, :nom, :prenom)");
        $stmt_personnes->bindParam(':idcentre', $idcentre);
        $stmt_personnes->bindParam(':nom', $nom);
        $stmt_personnes->bindParam(':prenom', $prenom);
        $fullname = $_POST['nom'];
        $fullname = $_POST['prenom'];
        $idcentre = $_POST['centre'];
        $result = $stmt_personnes->execute();
        $answer = 'echec' ;
        if ($result) {
            $answer = 'success';
        }
        $output=array('resultat'=>$answer );
        echo json_encode($output);
    }
    
    if (!empty($_POST['idSearch'])) {
        $stmt_respo = $db->prepare("SELECT * FROM personnes WHERE id=:id");
        $stmt_respo->bindParam(':id', $id);
        $id = $_POST['idSearch'];
        $result = $stmt_respo -> execute();
        if ($result) {
            $respos = $stmt_respo->fetch(PDO::FETCH_OBJ);
            $nom = $respos->nom;
            $prenom= $respos->prenom;
            $centre = $respos->idCentre;
            $answer = "success";
        }
        $output=array('resultat'=>$answer, 'nom'=>$nom, 'prenom'=>$prenom, 'centre'=>$centre );
        echo json_encode($output);
    }
?>