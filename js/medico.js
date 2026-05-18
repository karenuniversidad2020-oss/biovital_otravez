// Esperar a que APP_URL esté definida
$(document).ready(function() {
    // Verificar que APP_URL esté definida
    if (typeof APP_URL === 'undefined') {
        console.error('ERROR: APP_URL no está definida');
        $('#nombre_us').html('Error de configuración. Recargue la página.');
        return;
    }
    
    console.log('=== DEPURACIÓN MÉDICO ===');
    console.log('APP_URL:', APP_URL);
    
    var id_usuario = $('#id_usuario').val();
    var edit = false;
    
    console.log('ID Usuario:', id_usuario);
    
    if(!id_usuario || id_usuario === '') {
        console.error('ERROR: ID de médico no encontrado');
        $('#nombre_us').html('Error: Sesión no válida');
        return;
    }
    
    cargarDatosMedico(id_usuario);
    
    function cargarDatosMedico(id) {
        console.log('Cargando datos del médico ID:', id);
        console.log('URL de petición:', APP_URL + '/api/medicos/buscar');
        
        $.ajax({
            url: APP_URL + '/api/medicos/buscar',
            type: 'POST',
            data: { dato: id },
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                
                if(response.error) {
                    console.error('Error del servidor:', response.error);
                    $('#nombre_us').html('Error: ' + response.error);
                    return;
                }
                
                // Actualizar UI con los datos
                actualizarUI(response);
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX - Status:', status);
                console.error('Error AJAX - Detalle:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
                $('#nombre_us').html('Error de conexión: ' + status);
            }
        });
    }
    
    function actualizarUI(medico) {
        console.log('Actualizando UI con datos:', medico);
        
        $('#nombre_us').html(medico.nombre || 'No disponible');
        $('#apellidos_us').html(medico.apellidos || 'No disponible');
        $('#edad').html(medico.fecha_nacimiento || 'No disponible');
        $('#cedula_us').html(medico.cedula || 'No disponible');
        $('#us_tipo').html(medico.tipo || 'Médico');
        $('#telefono_us').html(medico.telefono || '-');
        $('#correo_us').html(medico.correo || '-');
        $('#sexo_us').html(medico.sexo || '-');
        $('#adicional_us').html(medico.adicional || '-');
        $('#direccion_us').html(medico.direccion || '-');
        
        // Cargar avatar
        if(medico.avatar && medico.avatar !== '') {
            var avatarUrl = medico.avatar;
            // Si la URL es relativa, agregar APP_URL
            if(avatarUrl.indexOf('http') === -1 && avatarUrl.indexOf('/') === 0) {
                avatarUrl = APP_URL + avatarUrl;
            } else if(avatarUrl.indexOf('http') === -1) {
                avatarUrl = APP_URL + '/' + avatarUrl;
            }
            console.log('Cargando avatar desde:', avatarUrl);
            $('#avatar1, #avatar2, #avatar3, #avatar4').attr('src', avatarUrl);
        } else {
            var defaultAvatar = APP_URL + '/img/avatarDES.jpg';
            $('#avatar1, #avatar2, #avatar3, #avatar4').attr('src', defaultAvatar);
        }
        
        console.log('UI actualizada correctamente');
    }
    
    // Evento para el botón editar (reemplaza la función existente)
$(document).on('click', '.edit', function(e) {
    e.preventDefault();
    edit = true;
    
    console.log('Editando médico ID:', id_usuario);
    
    // Mostrar indicador de carga
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Cargando...');
    
    $.ajax({
        url: APP_URL + '/api/medicos/capturar-datos',
        type: 'POST',
        data: { id_medico: id_usuario },
        dataType: 'json',
        success: function(medico) {
            console.log('Datos a editar:', medico);
            
            if(medico.error) {
                alert('Error: ' + medico.error);
                return;
            }
            
            // Llenar los campos del formulario
            $('#telefono').val(medico.telefono || '').prop('disabled', false);
            $('#direccion').val(medico.direccion || '').prop('disabled', false);
            $('#correo').val(medico.correo || '').prop('disabled', false);
            $('#sexo').val(medico.sexo || '').prop('disabled', false);
            $('#adicional').val(medico.adicional || '').prop('disabled', false);
            
            // Cambiar el botón de guardar
            $('.btn-outline-success').removeClass('btn-outline-success').addClass('btn-success').prop('disabled', false);
            
            // Mostrar mensaje de éxito
            $('#editado').show(1000);
            setTimeout(function() { $('#editado').hide(2000); }, 2000);
        },
        error: function(xhr, status, error) {
            console.error('Error al capturar datos:', error);
            alert('Error al cargar datos para edición: ' + status);
        },
        complete: function() {
            // Restaurar el botón editar
            $('.edit').html('Editar');
        }
    });
});

// Formulario de edición - Guardar cambios
$('#form-usuario').submit(function(e) {
    e.preventDefault();
    
    if (!edit) {
        alert('Primero haga clic en Editar');
        return;
    }
    
    var datos = {
        id_medico: id_usuario,
        telefono: $('#telefono').val(),
        direccion: $('#direccion').val(),
        correo: $('#correo').val(),
        sexo: $('#sexo').val(),
        adicional: $('#adicional').val()
    };
    
    console.log('Guardando datos:', datos);
    
    var $btn = $(this).find('button[type="submit"]');
    var originalText = $btn.html();
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
    
    $.ajax({
        url: APP_URL + '/api/medicos/editar',
        type: 'POST',
        data: datos,
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta editar:', response);
            
            if (response.success) {
                $('#editado').show(1000);
                setTimeout(function() { $('#editado').hide(2000); }, 2000);
                
                // Resetear formulario
                $('#form-usuario').trigger('reset');
                $('#telefono, #direccion, #correo, #sexo, #adicional').prop('disabled', true);
                edit = false;
                $('.btn-success').removeClass('btn-success').addClass('btn-outline-success').prop('disabled', true);
                
                // Recargar datos del médico
                cargarDatosMedico(id_usuario);
                
                alert('Datos actualizados correctamente');
            } else {
                $('#noeditado').show(1000);
                setTimeout(function() { $('#noeditado').hide(2000); }, 2000);
                alert(response.error || 'Error al guardar');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al editar:', error);
            $('#noeditado').show(1000);
            setTimeout(function() { $('#noeditado').hide(2000); }, 2000);
            alert('Error de conexión: ' + status);
        },
        complete: function() {
            $btn.prop('disabled', false).html(originalText);
        }
    });
});
    
   
    
    // Cambiar contraseña
    $('#form-pass').submit(function(e) {
        e.preventDefault();
        
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: APP_URL + '/api/medicos/cambiar-password',
            type: 'POST',
            data: {
                id_medico: id_usuario,
                oldpass: $('#oldpass').val(),
                newpass: $('#newpass').val()
            },
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta cambio contraseña:', response);
                
                if (response.resultado == 'update') {
                    $('#update').show(1000);
                    setTimeout(function() { $('#update').hide(2000); }, 2000);
                    $('#form-pass').trigger('reset');
                    setTimeout(function() { $('#cambiocontra').modal('hide'); }, 1500);
                } else {
                    $('#noupdate').show(1000);
                    setTimeout(function() { $('#noupdate').hide(2000); }, 2000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#noupdate').show(1000);
                setTimeout(function() { $('#noupdate').hide(2000); }, 2000);
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Cambiar foto
    $('#form-photo').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('id_medico', id_usuario);
        
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: APP_URL + '/api/medicos/cambiar-foto',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta cambio foto:', response);
                
                if (response.alert == 'edit') {
                    var nuevaRuta = response.ruta;
                    $('#avatar1, #avatar2, #avatar3, #avatar4').attr('src', nuevaRuta + '?t=' + new Date().getTime());
                    $('#edit').show(1000);
                    setTimeout(function() { $('#edit').hide(2000); }, 2000);
                    $('#form-photo').trigger('reset');
                    setTimeout(function() { $('#cambiophoto').modal('hide'); }, 1500);
                    cargarDatosMedico(id_usuario);
                } else {
                    $('#noedit').show(1000);
                    setTimeout(function() { $('#noedit').hide(2000); }, 2000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cambiar foto:', error);
                $('#noedit').show(1000);
                setTimeout(function() { $('#noedit').hide(2000); }, 2000);
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
});