function loadDoc() {
	var login = document.getElementById("identifiant").value;
	var pass = document.getElementById("pass").value;
	var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		document.getElementById("status").innerHTML = this.responseText;
	}
	};
	xhttp.open("POST", "fonction_connection.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("fname=identifiant&lname=pass");
}