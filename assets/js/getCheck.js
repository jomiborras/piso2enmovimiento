window.onload = function() {
	let profes = localStorage.getItem("profes");

	let parse = JSON.parse(profes);

	document.getElementById("profe-01").value = parse[0];

	document.getElementById("profe-02").value = parse[1];

	document.getElementById("profe-03").value = parse[2];


	}