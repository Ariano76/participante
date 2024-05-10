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

<h1 class="display-8">MAESTRO DE PERIODOS</h1> 
<div class="container">

</div>

<div class="col-lg-12">
  <div class="btnAdd">
    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-success btn-lg">Agregar Nuevo Item</a>
  </div>
  <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed small" style="width:100%">
    <thead class="text-center">
      <tr>
        <th>Codigo</th>
        <th>Mes</th>
        <th>Año</th>
        <th>Periodo</th>
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
        'url': 'periodos_fetch_data.php',
        'type': 'post',
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [4]
      },
      ]
    });
  });
  $(document).on('submit', '#addUser', function(e) {
    e.preventDefault();    
    var fecha_actividad = $('#addfecha_actividadField').val();
    var mes = $('#addmesField').val();
    if (fecha_actividad != '' && mes != '') {
      $.ajax({
        url: "periodos_add.php",
        type: "post",
        data: {
          fecha_actividad: fecha_actividad,
          mes: mes,
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
    //var nom_actividad = $('#nom_actividadField').val();
    var fecha_actividad = $('#fecha_actividadField').val();      
    var trid = $('#trid').val();
    var id = $('#id').val();
    if (nom_actividad != '') {
    $.ajax({
      url: "periodos_update.php",
      type: "post",
      data: {
        //nom_actividad: nom_actividad,
        fecha_actividad: fecha_actividad,
        id: id
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == 'true') {
          table = $('#tablaUsuarios').DataTable();
          var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a> </td>';
          var row = table.row("[id='" + trid + "']");

          row.row("[id='" + trid + "']").data([id, nom_actividad, fecha_actividad, button]);
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
        url: "periodos_get_single.php",
        data: {
          id: id
        },
        type: 'post',
        success: function(data) {
          var json = JSON.parse(data);
          //$('#nom_actividadField').val(json.nom_actividad);
          $('#fecha_actividadField').val(json.fecha_actividad);

          $('#id').val(id);
          $('#trid').val(trid);
          //console.log("La Respuesta esta_de_acuerdoField es :" + json.esta_de_acuerdo);

        }
      })
    });

  </script>
  <!-- Modal -->
  <!--div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"-->
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!--div class="modal-dialog" role="document"-->
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR ACTIVIDADES</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateUser">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="trid" id="trid" value="">
            
            <div class="mb-3 row">
              <label for="nom_actividadField" class="col-md-3 form-label">Nombre Actividad</label>
              <div class="md-form amber-textarea active-amber-textarea col-md-8">
                <textarea class="form-control rounded-0" name="text" id="nom_actividadField" rows="4" cols="45" maxlength="250" ></textarea>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="fecha_actividadField" class="col-md-3 form-label">Fecha realización</label>
              <div class="col-md-8">
                <input id="fecha_actividadField" type="date" name="fecha" value="2017-06-01">
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
          <h5 class="modal-title" id="exampleModalLabel">AGREGAR NUEVA ACTIVIDAD</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addUser" action="">
            <div class="mb-3 row">
              <label for="addmesField" class="col-md-3 form-label">Mes</label>
              <div class="col-md-9">
                <select class="form-select" id="addmesField" aria-label="Default select example" name="estatus">
                  <?php 
                  for ($i = 1; $i < 13; $i++) { 
                    $periodo_str = string($i);
                    if (strlen($periodo_str) == 1) {
                      $periodo_str="0"+$i;
                    }else{
                      $periodo_str=$i;
                    }
                    ?>
                    <option value="<?php echo $periodo_str; ?>"><?php echo $periodo_str;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addfecha_actividadField" class="col-md-3 form-label">Fecha realización</label>
              <div class="col-md-9">
                <input id="addfecha_actividadField" type="date" name="fecha" value="<?php echo date("Y-m-d"); ?>">
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