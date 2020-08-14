// Ejecutar hasta que se haya cargado el DOM
document.addEventListener('DOMContentLoaded', function () {
    window.localStorage.clear();
    
    // Máximo de profesores que se pueden seleccionar
    let max = 1;

    // Obtener todos los checkboxes por nombre
    let checks = document.querySelectorAll('[name="disable[]"]');

    // Recorrer para asignar evento cuando cambien
    checks.forEach(chk => chk.addEventListener('change', validation));

    // Validar
    function validation() {
        // Guardar profesores seleccionados en un arreglo
        let profes = [];
        // Obtener solo los que están marcados
        let checked = document.querySelectorAll(':checked');

        // Recorrer todos
        checks.forEach(chk => {
            // Si está marcado o no se ha llegado al límite
            if(chk.checked || checked.length < max) {
                // Quitar clase a etiqueta
                chk.closest('label').classList.remove('disabled');
                // Habilitar checkbox para permitir cambios
                chk.disabled = false;
                // Si está marcado, agregar a seleccionados
                if(chk.checked) {
                    profes.push(chk.value);
                }
            } else {
                // No está marcado y ya se llegó al límite
                chk.closest('label').classList.add('disabled');
                // Deshabilitar ckeckbox
                chk.disabled = true;

            }
        });
        // Guardar en localStorage
        localStorage.setItem("profes", JSON.stringify(profes));

        let rest = JSON.parse(localStorage.getItem("profes"));

        let button = document.getElementById('button');
        
        if (rest.length == max){

            button.classList.remove('disabled');
        }else if (rest.length != max){
            button.classList.add('disabled');
        }
    }

});