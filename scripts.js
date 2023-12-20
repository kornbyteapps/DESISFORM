// Carga inicial de regiones y candidatos
$(document).ready(() => {
  cargarRegiones();
  cargarCandidatos();
});
// Función para cargar la lista de candidatos desde la db
const cargarCandidatos = () => {
  $.ajax({
    url: "get-candidatos.php?action=getCandidatos",
    type: "GET",
    dataType: "json",
    success: (data) => {
      // Llenar el select de candidatos con la respuesta de la db
      const selectCand = $("#candidato");
      selectCand.empty().append('<option value="" disabled selected>Seleccione su candidato</option>');
      $.each(data, (index, candidato) => {
        selectCand.append(`<option value="${candidato.id_candidato}">${candidato.nombre_candidato}</option>`);//asigna el id al value de la opción y el nombre del candidato  como el contenido
      });
    },
    error: (error) => {
      console.error("Error al obtener los candidatos:", error);
    },
  });
};
// Función para cargar la lista de regiones desde la db
const cargarRegiones = () => {
  $.ajax({
    url: "get-regiones.php?action=getRegiones",
    type: "GET",
    dataType: "json",
    success: (data) => {
      const selectRegion = $("#region");
      $.each(data, (index, region) => {
        selectRegion.append(`<option value="${region.id_region}">${region.nombre_region}</option>`);
      });
    },
    error: (xhr, status, error) => {
      console.error("Error al obtener las regiones:", error);
      console.error("Respuesta del servidor:", xhr.responseText);
      console.error("Estado de la respuesta:", xhr.status);
    },
  });
};
// Función para cargar la lista de comunas una ves seleccionada una región

const cargarComunas = () => {
  const regionSeleccionada = $("#region").val();

  $.ajax({
    url: "get-comunas.php",
    type: "GET",
    data: { region: regionSeleccionada },
    dataType: "json",
    success: (data) => {
      const selectComuna = $("#comuna");
      selectComuna.empty();

      $.each(data, (index, comuna) => {
        selectComuna.append(`<option value="${comuna.id_comuna}">${comuna.nombre_comuna}</option>`);
      });
    },
    error: (xhr, status, error) => {
      console.error("Error al obtener las comunas:", error);
      console.error("Respuesta del servidor:", xhr.responseText);
    },
  });
};
// Función para valida los campos del formulario para mostrar feedback en tiempo real
const validarCampo = (campoId, mensajeErrorId) => {
  const campoInput = document.getElementById(campoId);
  const mensajeError = document.getElementById(mensajeErrorId);
  let regex;
  //comprueba que no esté vacío
  if (campoInput.value.trim() === "") {
    mensajeError.textContent = "Este campo no puede estar vacío.";
    return;
  }
  // Validación específica para cada campo
  switch (campoId) {
    case "nombre-apellido":
      mensajeError.textContent = "";
      break;
    case "alias":
      regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]{6,}$/;//expersión regular
      if (!regex.test(campoInput.value)) {
        if (/[^a-zA-Z0-9]/.test(campoInput.value)) {
          mensajeError.textContent = "No se admiten caracteres especiales.";
        } else {
          mensajeError.textContent = "Mínimo 6 caracteres entre letras y números.";
        }
      } else {
        mensajeError.textContent = "";
      }
      break;
    case "rut":
      regex = /^[0-9]+[-|‐]{1}[0-9kK]{1}$/; //formato Rut 11222333-4
      if (regex.test(campoInput.value)) {
        //Algoritmo Modulo 11 para DV
        const dv = campoInput.value.slice(-1).toUpperCase();
        const rutNumeros = campoInput.value.slice(0, -2);
        let suma = 0;
        let multiplo = 2;
        for (let i = rutNumeros.length - 1; i >= 0; i--) {
            suma += parseInt(rutNumeros[i]) * multiplo;
            multiplo = multiplo === 7 ? 2 : multiplo + 1;
          }
        const resto = suma % 11;
        const dvCalculado = resto === 0 ? 0 : 11 - resto;

        if ((dv.toLowerCase() === 'k' && dvCalculado === 10) || (dv == dvCalculado)) {
          mensajeError.textContent = "";
        } else {
          mensajeError.textContent = "Rut invalido.";
          }
        
      } else {
        mensajeError.textContent = "Formato de Rut incorrecto.";
      }
      break;
    case "email":
      regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,4}$/;
      if (!regex.test(campoInput.value)) {
        mensajeError.textContent = "Formato incorrecto.";
      } else {
        mensajeError.textContent = "";
      }
      break;
    case "candidato":
      
      if (campoInput.value==='') {
        
        mensajeError.textContent = "Seleccione un candidato";
      }else mensajeError.textContent = "";
      break;
    case "region":
      
      if (campoInput.value==='') {
        
        mensajeError.textContent = "Seleccione una región";
      }else mensajeError.textContent = "";
      break;
    case "comuna":
      
      if (campoInput.value==='') {
        
        mensajeError.textContent = "Seleccione una comuna";
      }else mensajeError.textContent = "";
      break;
  }
};
// validación de las checkboxes
const validarCheck = (campoId, mensajeErrorId) => {
  const mensajeError = document.getElementById(mensajeErrorId);
  const checkboxes = document.querySelectorAll('input[name="como-se-entero[]"]');
  let checkedCount = 0;

  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      checkedCount++;
    }
  });

  if (checkedCount < 2) {
    mensajeError.textContent = "Debes seleccionar al menos dos opciones.";
  } else {
    mensajeError.textContent = "";
  }
};
