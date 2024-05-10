<?php include("../administrador/template/cabecera.php"); 

include("../administrador/config/connection.php");

?>

<h1 class="display-8">CONSULTA DE PAQUETES RECIBIDOS</h1> 

<div class="col-lg-12">
  <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed w-auto small " style="width:100%">
    <!--table id="tablaUsuarios" class="table table-striped table-bordered table-condensed w-auto small nowrap" style="width:100%"-->
    <thead class="text-center">
      <tr>
        <th>ID</th>
        <th>Estado&nbsp;envío</th>
        <th>Fecha&nbsp;envío</th>
        <th>Usuario&nbsp;envío</th>
        <th>Estado&nbsp;pedido</th>
        <th>Fecha&nbsp;aprobación</th>
        <th>Beneficiarios</th>
        <th>&nbsp;&nbsp;Observaciones&nbsp;&nbsp;&nbsp;</th>
        <th>Acción</th>
        <th>Download</th>
      </tr>
    </thead>
  </table>   
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#tablaUsuarios').DataTable({
      "fnCreatedRow": function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
      },
      scrollX: true,
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
        'url': 'fetch_data_paquetes.php',
        'type': 'POST'
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [9]
      },
      ]
    });
  });
  $(document).on('submit', '#updateUser', function(e) {
    e.preventDefault();
      //var tr = $(this).closest('tr');
      var estado = $('#estadoField').val();
      var fecha_envio = $('#fecha_envioField').val();
      var nombre_usuario = $('#nombre_usuarioField').val();
      var estado_aprobacion = $('#estado_aprobacionField').val();
      var fecha_aprobacion = $('#fecha_aprobacionField').val();
      var numero_beneficiarios = $('#numero_beneficiariosField').val();
      var observaciones = $('#observacionesField').val();
      
      var codEstatus = $("input[name=estatus]:checked").val();

      var trid = $('#trid').val();
      var id = $('#id').val();
      
      $.ajax({
        url: "update_user_paquetes.php",
        type: "post",
        data: {
          estado: estado,
          fecha_envio: fecha_envio,
          nombre_usuario: nombre_usuario,
          estado_aprobacion: estado_aprobacion,
          fecha_aprobacion: fecha_aprobacion,
          numero_beneficiarios: numero_beneficiarios,
          observaciones: observaciones,
          id_estado: codEstatus,
          id: id
        },
        success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'true') {
            table = $('#tablaUsuarios').DataTable();
            var button = '<td align="center"><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a> </td>';
            var button1 = '<td align="center"><a href="#!" data-id="' + id + '" class="btn btn-info btn-sm downloadbtn">Download</a> </td> ';
            //var button2 = '<td align="center"><a class="delete_employee" data-bs-toggle="modal" data-bs-target="#addUserModal" data-emp-id="' + id + '" href=#!> <i class="fas fa-cloud-download-alt" style="color: blue"></i></a> </td> ';
            var row = table.row("[id='" + trid + "']");

            var nomEst;
            if (codEstatus==2) {
              nomEst = 'Pendiente'
            } else if (codEstatus==3){
              nomEst = 'Aprobado'
            } else if (codEstatus==4){
              nomEst = 'Rechazado'
            }

            row.row("[id='" + trid + "']").data([id, estado, fecha_envio, nombre_usuario, nomEst, fecha_aprobacion, numero_beneficiarios, observaciones, button, button1]);
            $('#exampleModal').modal('hide');
          } else {
            alert('failed');
          }
        }
      });
    });
  $('#tablaUsuarios').on('click', '.editbtn', function(event) {
    var table = $('#tablaUsuarios').DataTable();
    var trid = $(this).closest('tr').attr('id');
      // console.log(selectedRow);
      var id = $(this).data('id');
      $('#exampleModal').modal('show');

      $.ajax({
        url: "get_single_paquetes.php",
        data: {
          id: id
        },
        type: 'post',
        success: function(data) {
          var json = JSON.parse(data);
          $('#estadoField').val(json.estado);
          $('#fecha_envioField').val(json.fecha_envio);
          $('#nombre_usuarioField').val(json.nombre_usuario);
          $('#estado_aprobacionField').val(json.estado_aprobacion);
          $('#fecha_aprobacionField').val(json.fecha_aprobacion);
          $('#numero_beneficiariosField').val(json.numero_beneficiarios);
          $('#observacionesField').val(json.observaciones);
          $('#id').val(id);
          $('#trid').val(trid);
          //console.log("La Respuesta esta_de_acuerdoField es :" + json.fecha_aprobacion);
          if (json.estado_aprobacion == "Pendiente") {
            $('#exampleModal').find(':radio[name=estatus][value="2"]').prop('checked', true);
          } else if (json.estado_aprobacion == "Aprobado") {
            $('#exampleModal').find(':radio[name=estatus][value="3"]').prop('checked', true);
          } else if (json.estado_aprobacion == "Rechazado") {
            $('#exampleModal').find(':radio[name=estatus][value="4"]').prop('checked', true);
          } 
        }
      })
    });
  // codigo venta modal para descargar el archivo
  $('#tablaUsuarios').on('click', '.downloadbtn', function(e) {
    e.preventDefault();
    var trid = $('#trid').val();
    //var id = $('#id').val();
    var id = $(this).data('id');
    console.log('El codigo que se ha enviado es: '+id);
    //$('#downloadModal').modal('show');
    $.ajax({
      url: "repo_finanzas_valorizacion.php",
      type: "get",
      data: {
        id: id
      },
      success: function(data) {
        window.open('repo_finanzas_valorizacion.php?id='+id,'_blank' ); 

      }
    });
  });  
  
</script>

<script type="text/javascript">
    //escribir la hora actual en una caja de texto, segundo a segundo.
    $(document).ready(function() {
     setInterval(runningTime, 1000);
   });
    function runningTime() {
      $.ajax({
        url: 'timeScript.php',
        success: function(data) {
         $('#fecha_aprobacionField').val(data);
       },
     });
    }
  </script>

  <!-- Modal -->
  <!--div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"-->
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!--div class="modal-dialog" role="document"-->
    <div class="modal-dialog modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR ESTADO DE SOLICITUDES</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateUser">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="trid" id="trid" value="">

            <div class="mb-3 row">
              <label for="estadoField" class="col-md-4 form-label">Estado de envío</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="estadoField" name="name" disabled>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="fecha_envioField" class="col-md-4 form-label">Fecha de envío</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="fecha_envioField" name="name" disabled>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre_usuarioField" class="col-md-4 form-label">Usuario de envío</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="nombre_usuarioField" name="name" disabled>
              </div>
            </div>            
            <div class="mb-3 row">
              <label for="numero_beneficiariosField" class="col-md-4 form-label">N° Beneficiarios</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="numero_beneficiariosField" name="name" disabled>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="exampleFormControlTextarea6">Observaciones</label>
              <div class="form-group shadow-textarea">
                <textarea class="form-control z-depth-1" id="observacionesField" rows="3" placeholder="Puede escribir un comentario aqui..." maxlength="200"></textarea>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="fecha_aprobacionField" class="col-md-4 form-label">Fecha aprobación</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="fecha_aprobacionField" name="name" disabled>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="estado_aprobacionField" class="col-md-4 form-label">Estado Aprobación</label>
              <div class="col-md-8">
                <div class="custom-control custom-radio">
                  <input type="radio" id="id_estadoField1" name="estatus" class="custom-control-input" value="2">
                  <label class="custom-control-label" for="customRadio1">Pendiente</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="id_estadoField2" name="estatus" class="custom-control-input" value="3">
                  <label class="custom-control-label" for="customRadio2">Aprobado</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="id_estadoField3" name="estatus" class="custom-control-input" value="4">
                  <label class="custom-control-label" for="customRadio3">Rechazado</label>
                </div>                
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php include("../administrador/template/pie.php"); ?>