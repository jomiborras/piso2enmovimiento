window.onload = function() {
	let profes = localStorage.getItem("profes");

	let parse = JSON.parse(profes);

	document.getElementById("profe").value = parse[0];

	}