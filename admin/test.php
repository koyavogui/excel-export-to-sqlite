<?php
    $db = new PDO('sqlite:../database/devoir.db');
    $stmt_centre   = $db->prepare("SELECT * FROM centres WHERE centre=:centre"); 
    $stmt_centre->bindParam(':centre', $centres);
    $centres = 'AOK Learning Lt'  ; 
    $stmt_centre->execute();
    $centre = $stmt_centre->fetch(PDO::FETCH_OBJ);
    if ($centre == false){

         
    }
?>