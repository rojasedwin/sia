function cargarItems(){
	
	//mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'clientes/getItems/',
	   data: {},
	   success: function(res){
			 //ocultar_alerta();
		   $('#resultados_clientes').html(res);
			 //loadWidzardForm('resultados_usuarios');
			 
			  $("#tableClientes").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
  
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		}
	  
	  
    });
	
	
	


	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_clientes').html('');
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
			url: base_url+'clientes/getFormItem',
			data: {item_id:item_id},
			success: function(res){
				
				$('#contenido_clientes').html(res);
				$('#modal_cliente').modal('show');
				

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
	
	
	var cliente_nombre=$('#cliente_nombre').val();
	if(cliente_nombre==""){
				   
	Toast.fire({
        icon: 'error',
        title: 'El campo Razón Social es obligatorio.'
      })
		
	return false;	
	}
	
	var cliente_email=$('#cliente_email').val();
	if(cliente_email==""){
				   
	Toast.fire({
        icon: 'error',
        title: 'El campo email es obligatorio.'
      })
		
	return false;	
	}
	
	
 
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'clientes/saveItem',
     data:$('[name=form_datos_cliente]').serialize(),
     success: function(res){
       //ocultar_alerta();
       if(res.result==1)
       {
		    
		   $('#cliente_id').val(res.cliente_id);
           $('.modal').modal('hide');
         
		   
		  
		   
		     Toast.fire({
        icon: 'success',
        title: 'Los datos se han guardado correctamente'
      });
	 
	  setTimeout(() => {
			   
			   $('#resultados_clientes').html(res.html_clientes);
		  $("#tableClientes").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
  
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		}
	  
	  
    });
			   
			   

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
  title: 'Seguro desea eliminar este cliente?',
  text: "El cliente será eliminado y no será visible!",
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
     url: base_url+'clientes/adeItem',
     data:{item_id:item_id},
     success: function(res){
       //ocultar_alerta();
       if(res.result==1)
       {
		
		    Toast.fire({
        icon: 'success',
        title: 'El cliente se ha eliminado correctamente'
      })
			 
			//toastr.success('El usuario se ha eliminado correctamente.');

			
	setTimeout(() => {
			   
			   $('#resultados_clientes').html(res.html_clientes);
		  $("#tableClientes").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
  
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		}
	  
	  
    });
			   
			   

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
