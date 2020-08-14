window.localStorage.clear()

function validation(choosen, obj) {
	limit = 3;
	cont = 0;
	if (obj.checked) {


		for (i = 0; ele = document.getElementById('choosen').getElementsByTagName('input')[i]; ++i){
			
			if (ele.checked){
				cont++;
			}
		}

		for (i = 0; i < localStorage.length; i++){
			var key = localStorage.key(i);
			document.getElementById(key).checked = true;
		}

		if (cont > limit){
			obj.checked = false;
			alert('Solo se pueden elegir 3 (tres) profesores!');
		}
	}
}