<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js" integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg==" crossorigin="anonymous"></script>
<script>
    function search() {
        var xhttp;
        const str = document.getElementById("search").value ; 
        console.log(str);
        if (str.length == 0) { 
        return;
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("books").innerHTML = this.responseText;
        }
        };
        xhttp.open("GET", "traitement.php?search="+str, true);
        xhttp.send();   
    }
$(document).ready(function(){
$("#form").submit(function (event) {
    event.preventDefault();
    });
});
</script>