<?php
    $db = new PDO('sqlite:../database/devoir.db');
    if (!empty($_POST['idEdit'])) {
        $stmt_respo = $db->prepare("UPDATE personnes SET nom=:nom, prenom=:prenom, idCentre=:idcentre WHERE id=:id"); 
        $stmt_respo->bindParam(':id', $id);
        $stmt_respo->bindParam(':idcentre', $idCentre);
        $stmt_respo->bindParam(':nom', $nom);
        $stmt_respo->bindParam(':prenom', $prenom);

        $id         = $_POST['idEdit'];
        $idCentre   = $_POST['idcentre'];
        $nom        = $_POST['nom'];
        $prenom     = $_POST['prenom'];
        $result     = $stmt_respo -> execute();
        if ($result) {
            $answer = "success";
        }
        $output=array('resultat'=>$answer);
        echo json_encode($output);
    }
?>