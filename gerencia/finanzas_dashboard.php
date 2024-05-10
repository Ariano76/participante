<?php include("../administrador/template/cabecera.php"); ?>

<div class="col-md-12">

  <div class="card text-dark bg-light">
    
    <div class="card-body" align="center">
      
    <iframe title="Dashboard Análisis Financiero" width="1024" height="612" src="https://app.powerbi.com/view?r=eyJrIjoiZmQzNzBkNzMtYmU0Yy00ZTZlLTliYTUtZjYyOWRhZjI4ZjBjIiwidCI6ImM0YTY2YzM0LTJiYjctNDUxZi04YmUxLWIyYzI2YTQzMDE1OCIsImMiOjR9&pageName=ReportSectionfdbb68914c127bedefa1" frameborder="0" allowFullScreen="true"></iframe>
      
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class=card-text>
      <div class="<?php if(!empty($type)) { echo $type . " alert alert-success role=alert"; } ?>"><?php if(!empty($message)) { echo $message; } ?>
      </div>
  </div>
</div>


<?php include("../administrador/template/pie.php"); ?>