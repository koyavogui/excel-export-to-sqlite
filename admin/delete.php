<?php
    $db = new PDO('sqlite:../database/devoir.db');
    if (isset($_POST['idDelete']) && $_POST['idDelete'] !== "") {
        try {
            $id=$_POST['idDelete'];
            $sql = "DELETE FROM personnes WHERE id='$id'";
    
            // use exec() because no results are returned
            if($db->exec($sql)){
                $output = array('reponse'=>"success");
                echo json_encode($output); 
            }
          } catch(PDOException $e) {
            $output = array('reponse'=>$e);
            echo json_encode($output);
          }
        exit();
    }
?>