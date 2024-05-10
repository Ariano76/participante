/* version original

$(document).ready(function(){  
	$('.delete_employee').click(function(e){   
	   e.preventDefault();   
	   var empid = $(this).attr('data-emp-id');
	   var parent = $(this).parent("td").parent("tr");   
	   bootbox.dialog({
			message: "¿ Esta seguro de que desea eliminar el usuario ? " + empid,
			title: "<i class='fas fa-trash-alt'></i> Eliminar !",
			buttons: {
				success: {
					  label: "No",
					  className: "btn-success",
					  callback: function() {
					  $('.bootbox').modal('hide');
				  }
				},
				danger: {
				  label: "Eliminar!",
				  className: "btn-danger",
				  callback: function() {       
				   $.ajax({        
						type: 'POST',
						url: 'deleteRecords.php',
						data: 'empid='+empid        
				   })
				   .done(function(response){        
						bootbox.alert(response);
						parent.fadeOut('slow');        
				   })
				   .fail(function(){        
						bootbox.alert('Error....');               
				   })              
				  }
				}
			}
	   });   
	});  
 });
 */

 /* primera alternativa, funciona modal pero no la llamada a la pagina borrar.php
 $(document).ready(function(){  
 	$('.delete_employee').click(function(e){   
 		e.preventDefault(); 
 		var empid = $(this).attr('data-emp-id');
 		var dialog = bootbox.dialog({ 			
 			title: "<i class='fas fa-trash-alt'></i> Eliminar !",
 			message: "<p>¿ Esta seguro de que desea eliminar el usuario ?</p>",
 			size: 'large',
 			buttons: {
 				cancel: {
 					label: "No!",
 					className: 'btn-danger',
 					callback: function(){
 						console.log('Custom cancel clicked');
 					}
 				},
 				ok: {
 					label: "Eliminar!",
 					className: 'btn-success',
 					callback: function(){
 						$.ajax({        
 							type: 'POST',
 							url: 'deleteRecords.php',
 							data: 'empid='+empid        
 						})
 						.done(function(response){        
 							bootbox.alert(response);
 							parent.fadeOut('slow');        
 						})
 						.fail(function(){        
 							bootbox.alert('Error....');               
 						})   						
 					}
 				}
 			}
 		});
 	});
 });

 */

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
         	url: 'deleteRecords.php',
         	data: { empid:deleteid, accion:0 },
         	success: function(response){
             // Removing row from HTML Table
             if(response == 1){
             	$(el).closest('tr').css('background','tomato');
             	$(el).closest('tr').fadeOut(800,function(){
             		$(this).remove();
             	});
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