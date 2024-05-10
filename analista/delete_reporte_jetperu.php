<?php 
include("../administrador/template/cabecera.php"); 
include("../administrador/config/connection.php");
?>

<script type="text/javascript" src="script/bootbox.min.js"></script>

<h1 class="display-8">CONSULTA PERIODOS CARGADOS JETPERÚ</h1> 
<br>
<div class="container">

</div>
<div class="col-lg-12">
  <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed w-auto nowrap small" style="width:100%">
    <thead class="text-center">
      <tr>
        <th>Codigo</th>
        <th>Mes</th>
        <th>Año</th>
        <th>Total&nbsp;registros</th>
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
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
        'url': 'delete_reporte_jetperu_fetch_data.php',
        'type': 'post',
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [4]
      },
      ]
    });
  });
  // codigo para descargar el formato JETPERU
  $('#tablaUsuarios').on('click', '.deletebtn', function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    var anio = $(this).data('anio');
    var mes = $(this).data('mes');
    var mensaje = "¿Está seguro que desea eliminar los datos del año " + anio + " mes " + mes +"?";

    bootbox.confirm(mensaje, function(result) {
      if(result){
        $.ajax({
          url: "delete_periodo_jetperu.php",
          type: "post",
          data: {
            id: id, mes: mes, anio: anio
          },
          success: function(data) {
            var json = JSON.parse(data);
            status = json.status;
            if (status == 'true') {
              $("#" + id).closest('tr').remove();
            } else {
              alert('Se presento un error. Intente de nuevo.');
              return;
            }
          }
        });
      }
    }); 
  }); 

</script>

<?php include("../administrador/template/pie.php"); ?>