<?php

    $db = new PDO('sqlite:../database/devoir.db');
    $search = $_GET['search'];
    if (isset($_GET['search'])) {
        $respos =  $db->prepare("SELECT * FROM personnes WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%'");
        $respos ->execute();
        $respos = $respos->fetchAll(PDO::FETCH_OBJ);
        $nbr = count($respos);
        if ($respos) {
            echo '    <div class="w-100">
            <div class="d-flex col-sm-10 mx-auto mb-5">
                <h3 class="display-6 flex-grow-1"> '.$nbr.' Resultat(s)</h3>
                <button href="" class="btn btn-success" data-toggle="modal" data-target="#addBook"><i class="fas fa-plus"></i> Ajouter</button>
            </div>
        </div>

        <section class="d-flex justify-content-center flex-wrap">';
            foreach ($respos as $r) {
                    
                echo '
                <article class="d-flex justify-content-center p-3" style="width: 14rem;">
                    <div class="card" style="width: 12rem;">
                        <img src="../image/seller.png" class="card-img-top img-fluid mt-1" alt="..." style=" ">
                        <div class="card-body d-flex flex-column">
                            <p class="card-title h6">  '.$r->nom.'  </p>
                            <p class="card-title h6">  '.$r->prenom.'  </p>';
                             
                                $stmt_centre   = $db->prepare("SELECT centre FROM centres WHERE id=:centre"); 
                                $stmt_centre->bindParam(':centre', $centres);
                                $centres = $r->idCentre; 
                                $stmt_centre->execute();
                                $centre = $stmt_centre->fetch(PDO::FETCH_OBJ);
                            
                            echo '<p class="card-text">'.$centre->centre.'</p>
                            <div class="text-center mt-auto">
                                <span class="mr-3 text-success" data-toggle="modal" data-target="#editModal"  data-id="'.$r->id.'"><i class="fas fa-pen"></i></span>
                                <span class="text-danger" data-toggle="modal" data-target="#deleteModal"  data-delete=" '.$r->id.'"><i class="fas fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </article>
               ';

            }
            echo' </section>';
             }else {
                echo '<div class="w-100">
                <div class="d-flex col-sm-10 mx-auto mb-5">
                    <h3 class="display-6 flex-grow-1">'.$nbr.' Responsable(s)</h3>
                    <button href="" class="btn btn-success" data-toggle="modal" data-target="#addrespo"><i class="fas fa-plus"></i> Ajouter</button>
                </div>
            </div>';
             }
    }
?>