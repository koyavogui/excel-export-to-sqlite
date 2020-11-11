$(document).ready(function(){

    var editModal = document.getElementById('editModal')
    const deleteModal = document.getElementById('deleteModal')
    editModal.addEventListener('show.bs.modal', function (event) {
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-* attributes
      var id= button.getAttribute('data-id')
      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      var modalTitle = editModal.querySelector('.modal-title')
      var modalBodynom = editModal.querySelector('.modal-body #nom')
      var modalBodyprenom = editModal.querySelector('.modal-body #prenom')
      var modalBodyselect = editModal.querySelector('.modal-body  select')
        $.post( "add.php", { idSearch: id}, function( data ) {
        if (data.resultat == 'success') { 
            modalTitle.textContent = 'Modification de '+ data.nom
            modalBodynom.value = data.nom
            modalBodyprenom.value = data.prenom
            modalBodyselect.value = data.centre 
        }
        }, "json");
    
        $('#editF').click(function () { 
             const nom = modalBodynom.value
             const prenom = modalBodyprenom.value
             const idcentre = modalBodyselect.value
             $.post( "edit.php", { idEdit: id, nom: nom, prenom: prenom, idcentre: idcentre}, function( data ) {
                if (data.resultat == 'success') { 
                    $( "#close_edit" ).html("Fermer");
                    $('#editF').hide()
                }
                }, "json");
        });  
        $('#close_edit').click(function () {  
            $( "#close_edit" ).html("Annuler");
            $( "#editF" ).show();
            $( "#books" ).load("index.php #books" );
        })

    }) 

    deleteModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-* attributes
        var id= button.getAttribute('data-delete')
  
        
          $('#delete').click(function () { 
            console.log(id)
               $.post( "delete.php", { idDelete: id}, function( data ) {
                  if (data.reponse == 'success') { 
                      $( "#close_delete" ).html("Fermer");
                      $('#delete').hide()
                      $( "#books" ).load("index.php #books" );
                  }
                  }, "json");
          });  
          $('#close_delete').click(function () {  
              $( "#close_delete" ).html("Annuler");
              $( "#delete" ).show();
          })
  
      }) 
     
    $('#add').click(function () {  
        $( "#modalForm" ).submit(function (event) {  
                event.preventDefault();
            });
            const form = $("#modalForm");
            var formdata = new FormData(form[0]);
            const nom = $("#recipient-name").val();
            const prenom = $("#recipient-prename").val();
            const centre = $("#form-select").val();
            if (nom != "" && centre !="") {     
                $.post( "add.php", { nom: nom, prenom: prenom, centre : centre}, function( data ) {
                    if (data.resultat == 'success') {
                        $( "#insertionLabel" ).html( '<h3 class="text-success" role="alert">Responsable ajouter</h3>' );
                        $( "#add" ).hide();
                        $( "#books" ).load("index.php #books" );
                    }
                  }, "json");
            }
    }) 
    $('#close_add').click(function () {  
        $( "#insertionLabel" ).html("Ajout d'un responsable");
        $( "#add" ).show();
    })
})