<?php
    $db = new PDO('sqlite:../database/devoir.db');
    $responsable = $db->query("SELECT * FROM personnes ORDER BY id ASC");
    $respo = $responsable->fetchAll(PDO::FETCH_OBJ);
    $nbr = count($respo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require '../includes/head.php' ?>
    <title>Akwaba</title>
    <style>
        .auteur{
      
             
        }
    </style>
</head>
<body class="px-0">  
 
    <div class="container-fluid px-0">
        <header class="container-fluid bg-info mb-3" style="">
        <nav class="container navbar navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand text-light" href="./">
                <img src="../image/biblio.png" alt="" width="30" height="24" class="d-inline-block align-top">
                    Mes Responsables
                </a>
                <i class="fas fa-user text-light"></i>
            </div>
        </nav>
        </header>
        <div class="container mb-5">
            <form class="d-flex" id="form">
                <input class="form-control mr-2 " type="search" name="search" id="search" placeholder="Chercher un responsable" aria-label="Search">
                <div class="btn btn-outline-primary"  onclick="search()"><i class="fas fa-search"></i></div>
            </form>
        </div>
        <section class="container-fluid">
            <section class="d-flex justify-content-start flex-wrap" id="books">
                <div class="w-100">
                    <div class="d-flex col-sm-10 mx-auto mb-5">
                        <h3 class="display-6 flex-grow-1"><?php echo $nbr;?> Responsable(s)</h3>
                        <button href="" class="btn btn-success"  data-toggle="modal" data-target="#insertion"><i class="fas fa-plus"></i> Ajouter</button>
                    </div>
                </div>

                <section class="d-flex justify-content-center flex-wrap">

                <?php foreach ($respo as $r) {?>
                    
                    <article class="d-flex justify-content-center p-3" style="width: 14rem;">
                        <div class="card" style="width: 12rem;">
                            <img src="../image/seller.png" class="card-img-top img-fluid mt-1" alt="..." style=" ">
                            <div class="card-body d-flex flex-column">
                                <p class="card-title h5"><?php echo $r->nom;?> </p>
                                <p class="card-title h5"><?php echo $r->prenom;?> </p>
                                <?php
                                    $stmt_centre   = $db->prepare("SELECT centre FROM centres WHERE id=:centre"); 
                                    $stmt_centre->bindParam(':centre', $centres);
                                    $centres = $r->idCentre; 
                                    $stmt_centre->execute();
                                    $centre = $stmt_centre->fetch(PDO::FETCH_OBJ);
                                ?>
                                <p class="card-text"><?php echo $centre->centre ;?></p>
                                <div class="text-center mt-auto">
                                    <span class="mr-3 text-success" data-toggle="modal" data-target="#editModal"  data-id="<?php echo $r->id; ?>"><i class="fas fa-pen"></i></span>
                                    <span class="text-danger" data-toggle="modal" data-target="#deleteModal"  data-delete="<?php echo $r->id; ?>"><i class="fas fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    </article>
                    
                <?php }?>

                </section>
            </section>
        </section>

        <!-- modal delete -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Supression</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     Voulez-vous vraiment supprimer ce responsable ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_delete">Annuler</button>
                    <button type="button" class="btn btn-danger" id="delete"> Delete</button>
                </div>
                </div>
            </div>
        </div>
        <!-- modal edit -->
        
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nom" class="col-form-label">Nom : </label>
                            <input type="text" class="form-control" id="nom">
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="col-form-label">Prenoms :</label>
                            <input type="text" class="form-control" id="prenom">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-centre" class="col-form-label">Centre : </label>
                            <select class="form-select" id="form-select" >
                                <option selected>Choisir un centre</option>
                                <?php 
                                    $centre = $db->query("SELECT * FROM centres");
                                    $centre = $centre->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($centre as $c) {
                                ?>
                                <option value="<?php echo $c->id ;?>"><?php echo $c->centre ; }?></option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_edit">Annuler</button>
                    <button type="button" class="btn btn-primary" id="editF"> Modifier</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal  add-->
        <div class="modal fade " id="insertion" tabindex="-1" aria-labelledby="insertionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-success">
            <div class="modal-header">
                 
                    <h5 class="modal-title" id="insertionLabel" >Ajout d'un responsable</h5>
                
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                  <form method="post" id="modalForm">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nom :</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-prename" class="col-form-label">Prenoms :</label>
                        <input type="text" class="form-control" id="recipient-prename">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-centre" class="col-form-label">Centre : </label>
                        <select class="form-select" id="form-select" >
                            <option selected>Choisir un centre</option>
                            <?php 
                                $centre = $db->query("SELECT * FROM centres");
                                $centre = $centre->fetchAll(PDO::FETCH_OBJ);
                                foreach ($centre as $c) {
                            ?>
                            <option value="<?php echo $c->id ;?>"><?php echo $c->centre ; }?></option>
                        </select>
                    </div>
                  </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_add" >Close</button>
                <button type="button" class="btn btn-primary" id="add">Ajouter</button>
            </div>
            </div>
        </div>
        </div>
    </div>
    <?php require '../includes/script.php' ?>
    <script src="../includes/edit.js"></script>
</body>
</html>
 