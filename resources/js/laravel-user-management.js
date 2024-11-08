/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
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
    $("#tematicas").DataTable({
      lengthMenu: [ 
        [5, 10, 25, -1], 
        [5, 10, 25, "Todos"]
      ],
      pageLength: 10 
    });
  }
  
  

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}user-list/${user_id}`,
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: 'The user has been deleted!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'The User is not deleted!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).on('click', '.edit-record', function () {
    $(".offcanvas-title").html("Editar temática");
    var user_id = $(this).data('id');
    var user_titulo = $(this).data('titulo');
    var user_descripcion = $(this).data('descripcion');
    var user_orden = $(this).data('orden');
    var user_color = $(this).data('color'); 
    var dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // Set action URL and form method for editing
    var updateUrl = '/tematicas/' + user_id;
    $('#userForm').attr('action', updateUrl);
    $('#method').val('PUT'); // Cambia el método a PUT para edición
    $('#tematica_id').val(user_id); // Guarda el ID de la temática

    // Rellena los campos con los datos existentes
    $("#titulo").val(user_titulo);
    $("#descripcion").val(user_descripcion);
    $("#orden").val(user_orden);
    $("#color").val(user_color); 

    // Muestra el offcanvas
    var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasUser'));
    offcanvas.show();
});

// Para agregar una nueva temática
$(document).on('click', '#addNewTematicaButton', function () {
    // Reinicia el formulario para agregar
    $(".offcanvas-title").html("Agregar nueva temática");
    $('#userForm').attr('action', '/tematicas');
    $('#method').val('POST'); // Cambia el método a POST para agregar
    $('#tematica_id').val(''); // Limpia el ID de la temática
    $('#titulo').val('');
    $('#descripcion').val('');
    $('#orden').val('');
    $('#color').val('#5BC5C3'); // Restablece al color por defecto

    // Muestra el offcanvas
    var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasUser'));
    offcanvas.show();
});



  // changing the title
  $('.add-new').on('click', function () {
    $('#user_id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Agregar tematica');
  });

  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv.resetForm(true);
  });

  const phoneMaskList = document.querySelectorAll('.phone-mask');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }
});
