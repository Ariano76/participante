<?php include("../administrador/template/cabecera.php"); 

include("../administrador/config/connection.php");

?>
<style type="text/css">
  .btnAdd {
    text-align: right;
    width: 100%;
    margin-bottom: 20px;
  }
</style>

<h1 class="display-8">MAESTRO DEA</h1> 
<div class="container">

</div>

<div class="col-lg-12">
  <div class="btnAdd">
    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-success btn-lg">Agregar Nuevo Item</a>
  </div>
  <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed small" style="width:100%">
    <thead class="text-center">
      <tr>
        <th>Código</th>
        <th>Código DEA</th>
        <th>Descripción</th>
        <th>Acción</th>
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
        'url': 'dea_fetch_data.php',
        'type': 'post',
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [3]
      },
      ]
    });
  });
  $(document).on('submit', '#addUser', function(e) {
    e.preventDefault();
    var dea = $('#adddeaField').val();
    var descripcion = $('#adddescripcionField').val();
    if (dea != '' && descripcion != '') {
      $.ajax({
        url: "dea_add.php",
        type: "post",
        data: {
          dea: dea,
          descripcion: descripcion,
        },
        success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'true') {
            mytable = $('#tablaUsuarios').DataTable();
            mytable.draw();
            $('#addUserModal').modal('hide');
          } else {
            alert('failed');
          }
        }
      });
    } else {
      alert('Complete todos los campos requeridos');
    }
  });  
  $(document).on('submit', '#updateUser', function(e) {
    e.preventDefault();
    var dea = $('#deaField').val();
    var descripcion = $('#descripcionField').val();      
    var trid = $('#trid').val();
    var id = $('#id').val();
    if (dea != '') {
      $.ajax({
        url: "dea_update.php",
        type: "post",
        data: {
          dea: dea,
          descripcion: descripcion,
          id: id
        },
        success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'true') {
            table = $('#tablaUsuarios').DataTable();
            var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a> </td>';
            var row = table.row("[id='" + trid + "']");

            row.row("[id='" + trid + "']").data([id, dea, descripcion, button]);
            $('#exampleModal').modal('hide');
          } else {
            alert('failed');
          }
        }
      });
    } else {
      alert('Complete todos los campos requeridos');
    }
  });
  $('#tablaUsuarios').on('click', '.editbtn ', function(event) {
    var table = $('#tablaUsuarios').DataTable();
    var trid = $(this).closest('tr').attr('id');
      // console.log(selectedRow);
      var id = $(this).data('id');
      $('#exampleModal').modal('show');

      $.ajax({
        url: "dea_get_single.php",
        data: {
          id: id
        },
        type: 'post',
        success: function(data) {
          var json = JSON.parse(data);
          $('#deaField').val(json.dea);
          $('#descripcionField').val(json.descripcion);

          $('#id').val(id);
          $('#trid').val(trid);
        }
      })
    });

  </script>
  <!-- Update DEA Modal -->
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR DEA</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateUser">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="trid" id="trid" value="">

            <div class="mb-3 row">
              <label for="deaField" class="col-md-3 form-label">Código DEA</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="deaField" name="City" maxlength="20">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="descripcionField" class="col-md-3 form-label">Descripción DEA</label>
              <div class="md-form amber-textarea active-amber-textarea col-md-8">
                <textarea class="form-control rounded-0" name="text" id="descripcionField" rows="4" cols="45" maxlength="255" ></textarea>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add user Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">AGREGAR NUEVO DEA</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addUser" action="">
            <div class="mb-3 row">
              <label for="adddeaField" class="col-md-3 form-label">Código DEA</label>
              <div class="col-md-9">  
                <input type="text" class="form-control" id="adddeaField" name="City" maxlength="20">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="adddescripcionField" class="col-md-3 form-label">Descripción DEA</label>
              <div class="col-md-9">
                <textarea class="form-control rounded-0" name="text" id="adddescripcionField" rows="4" cols="45" maxlength="255" autocomplete="off"></textarea>
              </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Grabar</button>
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