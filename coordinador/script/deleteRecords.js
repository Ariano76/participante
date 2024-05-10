/* version original

 /* tercer intento: */

 $(document).ready(function(){
  // Delete 
  $('.delete_employee').click(function(){
  	var el = this;
    // Delete id
    var deleteid = $(this).attr('data-emp-id');
    // Confirm box
    bootbox.confirm("¿ Esta seguro de que desea eliminar el usuario ? ", function(result) {
    	if(result){
         // AJAX Request
         $.ajax({
         	type: 'POST',         	
         	url: 'repo_finanzas_valorizacion.php',
         	data: { empid:deleteid, accion:0 },
         	success: function(response){
             // Removing row from HTML Table
             if(response == 1){
             	bootbox.alert('OK.');
             }else{
             	bootbox.alert('Record not deleted.');
             }
         }
     });
     }
 });
});

  $('.update_pass').click(function(){
  	var el = this;
    // Delete id
    var deleteid = $(this).attr('data-emp-id');
    // Confirm box
    bootbox.prompt({
    	title: "<i class='fas fa-edit'></i> Actualizar Contraseña !",
    	//title: "This is a prompt, vertically centered!", 
    	centerVertical: true,
    	callback: function(result){ 
    		if (result != "") {
        	// AJAX Request
        	$.ajax({
        		type: 'POST',         	
        		url: 'deleteRecords.php',
        		data: { empid:deleteid, accion:1, clave:result},
        		success: function(response){
             // Removing row from HTML Table
             if(response == 1){
             	bootbox.alert('Contraseña actualizada.');
             }
         }
     });    			
        	console.log(result); 
        }    		
    }
});
});




});