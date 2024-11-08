/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-cartas'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasAddUser');

  if (select2.length) {
    var $this = select2;
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Users datatable
  if (dt_user_table.length) {
    $("#cartas").DataTable({
      lengthMenu: [ 
        [5, 10, 25, -1], 
        [5, 10, 25, "Todos"]
      ],
      pageLength: 10 
    });
  }
  
  
  $(document).on('click', '.delete-record', function () {
    var deleteUrl = $(this).data('url'); // Obtener la URL del atributo data-url
    var button = $(this);

    // SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, elimínalo!',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.isConfirmed) {
            // Solicitud AJAX para eliminar la carta
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _method: 'DELETE', // Usamos DELETE ya que Laravel espera este método
                    _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF para proteger la solicitud
                },
                success: function (response) {
                    // Mostrar SweetAlert de éxito y recargar la página
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado!',
                        text: 'La carta ha sido eliminada.',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    }).then(function () {
                        location.reload(); // Recargar la página tras el éxito
                    });
                },
                error: function (error) {
                    // Mostrar SweetAlert de error si la eliminación falla
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al eliminar la carta. Intenta de nuevo.',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                    console.log(error); // Opcional: para ver detalles en consola
                }
            });
        } else if (result.isDismissed) {
            // Si el usuario cancela la eliminación
            Swal.fire({
                title: 'Cancelado',
                text: 'La carta no fue eliminada.',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        }
    });
});







  $(document).on('click', '.edit-record', function () {
    $(".offcanvas-title").html("Editar carta");
    var carta_id = $(this).data('id');
    var tematica_id = $("#tematica_id").val();
    var carta_titulo = $(this).data('titulo');
    var carta_descripcion = $(this).data('descripcion'); 
    var dtrModal = $('.dtr-bs-modal.show');

    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    var updateUrl = '/tematicas/' + tematica_id + '/cartas/' + carta_id ;
    $('#cartaForm').attr('action', updateUrl);
    $('#method').val('PUT');
    $("#id").val(carta_id);
    $("#titulo").val(carta_titulo);
    $("#descripcion").val(carta_descripcion);

    var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCarta'));
    offcanvas.show();
});

$(document).on('click', '#add-carta', function () {
    var tematica = $('#tematica_id').val();
    $(".offcanvas-title").html("Agregar nueva carta");
    $('#cartaForm').attr('action', `/tematicas/${tematica}/cartas`);
    $('#method').val('POST');
    $('#id').val(''); 
    $('#titulo').val('');
    $('#descripcion').val(''); 

    var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCarta'));
    offcanvas.show();
});



  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv.resetForm(true);
  });

  

  console.log('hola');
});
