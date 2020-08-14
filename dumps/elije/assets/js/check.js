function validation(choosen, obj) {
	limit = 3;
	cont = 0;
	if (obj.checked) {
		for (i = 0; ele = document.getElementById(choosen).children[i]; i++)
			if (ele.checked) cont++;
		if (cont > limit)
			obj.checked = false;
	}

	if (cont > limit){
		alert('Solo se pueden elegir 3 (tres) profesores!')
	}
}


