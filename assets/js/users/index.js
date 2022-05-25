function cargarItems(){
	
	//mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'users/getItems/',
	   data: $('[name=pedidos_filter]').serialize(),
	   success: function(res){
			 //ocultar_alerta();
		   $('#resultados_usuarios').html(res);
			 //loadWidzardForm('resultados_usuarios');
			 
			  $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
  
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		},
     
    });
	
	
	


	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_usuarios').html('');
			//mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}


function fichaItem(item_id){
	
	

   item_id = typeof item_id !== 'undefined' ? item_id : "";
	// mostrar_alerta("alerta_info","Guardando...por favor, espere");
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'users/getFormItem',
			data: {item_id:item_id},
			success: function(res){
				
				$('#contenido_users').html(res);
				$('#modal_user').modal('show');
				
				
				
				

			},
			error: function(){
			 //mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX
}

function guardarItem(){
 
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
	
	var user_email=$('#user_email').val();
	if(user_email==""){
				   
	Toast.fire({
        icon: 'error',
        title: 'El campo email es obligatorio.'
      })
		
	return false;	
	}
 
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'users/saveItem',
     data:$('[name=form_datos_user]').serialize(),
     success: function(res){
       //ocultar_alerta();
       if(res.result==1)
       {
		   $('#resultados_usuarios').html(res.html_users);
		   $('#user_id').val(res.user_id);
           $('.modal').modal('hide');
         
		   
		  
		   
		     Toast.fire({
        icon: 'success',
        title: 'Los datos se han guardado correctamente'
      });
	  
	  setTimeout(() => {
			   
			   
		  $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
  
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		}
	  
	  
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			   
			   

}, 3000);		
	  
  //cargarItems();
       }
       else {
		   
		   
		Toast.fire({
        icon: 'error',
        title: 'El email introducido ya existe.'
      })
		   
          //$('#validation_item_errors').html(res.message);
		 
		  
		
		  
       }
     },
     error: function(){
      //mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}

function deleteItem(item_id){
	
	var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
	
	Swal.fire({
  title: 'Seguro desea eliminar este usuario?',
  text: "El usuario será eliminado y no será visible!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Eliminar'
}).then((result) => {
  if (result.isConfirmed) {
	  
	  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'users/adeItem',
     data:{item_id:item_id},
     success: function(res){
       //ocultar_alerta();
       if(res.result==1)
       {
		     $('#resultados_usuarios').html(res.html_users);

		    Toast.fire({
        icon: 'success',
        title: 'El usuario se ha eliminado correctamente'
      })
			 
			//toastr.success('El usuario se ha eliminado correctamente.');

			
	setTimeout(() => {
			   
			 
		  $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
  
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		}
	  
	  
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			   
			   

}, 3000);		
			
			 
			 
       }
       else {
          //$('#validation_item_errors').html(res.message);
       }
     },
     error: function(){
      //mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
	  
	  
    
  }
})
	
}




$( document ).ready(function() {
//alert();
	cargarItems();
	
	//loadSearchForm("pedidos_filter",cargarItems);

});
