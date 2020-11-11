<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
require_once '../vendor/autoload.php';
    $db = new PDO('sqlite:../database/devoir.db');
    // $books = $db->query("SELECT * FROM centres");
    // var_dump($db);
    // $book = $books->fetchAll(PDO::FETCH_OBJ);
    // var_dump($book);
    $sql_centre ='CREATE TABLE IF NOT EXISTS  "centres" (
        "id"	INTEGER,
        "centre"	TEXT,
        PRIMARY KEY("id" AUTOINCREMENT)
        );';
    $sql_personne ='CREATE TABLE IF NOT EXISTS  "personnes" (
        "id"	INTEGER,
        "idCentre"	INTEGER,
        "nom"	TEXT,
        "prenom"	INTEGER,
        PRIMARY KEY("id" AUTOINCREMENT)
    );';
    $createCentre = $db->query($sql_centre) ;
    $createPersonne = $db->query($sql_personne);
    if (isset($_FILES['file']) && !empty($_FILES['file']['name']) ) {
        if (isset($_POST['submit'])) {
         
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
             
            if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
             
                $arr_file = explode('.', $_FILES['file']['name']);
                $extension = end($arr_file);
             
                if('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                $reader->setReadDataOnly(TRUE);
                $reader->setLoadSheetsOnly(["Sheet 1", "List of Centres"]);
                $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
         
                // $sheetData = $spreadsheet->getActiveSheet();
                $worksheet = $spreadsheet->getActiveSheet();
                // Get the highest row and column numbers referenced in the worksheet
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
                /**
                 * Insertion des centres apres importation.
                 */
                $i=0;
                for ($row = 2; $row <= $highestRow; ++$row) { 
                    $stmt_centre   = $db->prepare("SELECT * FROM centres WHERE centre=:centre"); 
                    $stmt_centre->bindParam(':centre', $centres);
                    $centres = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $stmt_centre->execute();
                    $centre = $stmt_centre->fetch(PDO::FETCH_OBJ);
                    if ($centre == false){
                        $stmt = $db->prepare("INSERT INTO centres (centre) VALUES (:centre)");
                        $stmt->bindParam(':centre', $centres);
                        $centres = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $result = $stmt->execute();
                    }
                }
                //$result= array_unique($input);
                 
                //$lenght = count($result);
                // for ($row = 0; $row < $lenght; ++$row) {
                //                 //code...
                //                 echo $result[$row];
                //                 if ($result[$row] !== NULL) {
                //                     $stmt = $db->prepare("INSERT INTO centres (centre) VALUES (:centre)");
                //                     $stmt->bindParam(':centre', $centres);
                //                     $centres = $result[$row];
                //                         $stmt->execute();
                //                 }
                // }
                
         
               /**
                * insertion des responsables de centre
                */
        
                for ($row = 2; $row <= $highestRow; ++$row) {
                            $stmt_personnes = $db->prepare("INSERT INTO personnes (idCentre, nom, prenom) VALUES (:idcentre, :nom, :prenom)");
                            $stmt_centre   = $db->prepare("SELECT id FROM centres WHERE centre=:centre"); 
                            $stmt_centre->bindParam(':centre', $centres);
                            $centres = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            $stmt_centre->execute();
                            $centre = $stmt_centre->fetch(PDO::FETCH_OBJ);
                            $stmt_personnes->bindParam(':idcentre', $idcentre);
                            $stmt_personnes->bindParam(':nom', $nom);
                            $stmt_personnes->bindParam(':prenom', $prenom);
                            $fullname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                            $fullname = explode(" ",$fullname, 2);
                            $prenom = $fullname[0];
                            $nom = $fullname[1];
                            $idcentre = $centre->id;
                            echo $idcentre;
                             $chic = $stmt_personnes->execute();
                }
                    unset($_POST);
                    header('location:./');
             }
        }
    }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importation base de données</title>
</head>
<body>
    <div class="">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputFile">File Upload</label>
                <input type="file" name="file" class="form-control" id="exampleInputFile">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>