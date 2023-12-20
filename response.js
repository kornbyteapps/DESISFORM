//obtener contenido del formulario
var formulario = document.getElementById('votos');
formulario.addEventListener('submit', function (e) {
  e.preventDefault();
  var datos = new FormData(formulario);
// petición a validar.php para recibir el estado de la validación
  fetch('validar.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
     
      // Verificar si el rut ya está registrado
      if (Object.keys(data).length === 1 && data.hasOwnProperty('err-rut') && data['err-rut'] === 'FALSE') {
        // mostrar modal con mensaje específico
        setTimeout(function () {
          location.reload();
        }, 5000);
        $('#alert-modal #titulo').text('Envío fallido');
        $('#alert-modal .modal-body').html('<p>Usted ya ha registrado su voto.</p>');
        $('#alert-modal').modal('show');
        
        // En caso de éxito
      } else if (data.hasOwnProperty('success') && data.success === 'ok') {
        // Éxito: mostrar modal con mensaje de succes
        $('#alert-modal #titulo').text('Envío exitoso');
        $('#alert-modal .modal-body').html('<p>Hemos registrado su voto con éxito.</p>');
        $('#alert-modal').modal('show');
        // Recargar la página después de 3 segundos (3000 milisegundos)
        setTimeout(function () {
          location.reload();
        }, 3000);
      } else {
        // Error: mostrar mensajes de error
        for (var clave in data) {
          if (data.hasOwnProperty(clave)) {
            var valor = data[clave];
            //detecta si la respuesta de rut es FALSE para modificar su contenido, evitando un mensaje como "rut ya registrado"
            if (valor === 'FALSE') {
              valor  ='';
            }
            console.log('Clave: ' + clave + ', Valor: ' + valor);
            const mensajeError = document.getElementById(clave);
            mensajeError.textContent = valor;
          }
        }
      }
    });
});


