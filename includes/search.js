function search() {
    var xhttp;
    const str = document.getElementById("search").value ; 
    console.log(str);
    if (str.length == 0) { 
      document.getElementById("txtHint").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("books").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "traitement.php?q="+str, true);
    xhttp.send();   
  }
$(document).ready(function(){
$("#form").submit(function (event) {
    event.preventDefault();
    search();
    });
});