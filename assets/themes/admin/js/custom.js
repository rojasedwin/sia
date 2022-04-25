$( document ).ready(function() {

    //Mostramos/Cerramos sidebar de mensajes no leidos
	$('#a-open_mensajes_no_leidos').click(function(){
		classie.toggle( document.getElementById('menu-mensajes_no_leidos'), 'cbp-spmenu-open' );
	});

	$('#a-close_mensajes_no_leidos').click(function(){
		classie.toggle( document.getElementById('menu-mensajes_no_leidos'), 'cbp-spmenu-open' );
	});

    //Mostramos/Cerramos sidebar de mensajes de pedidos
    $( document ).on( "click", ".a-open_mensajes_pedido", function() {
		//Parseamos variables.
		var id = this.id;
		var arr_id = id.split("-");
		var order_id = arr_id[2];

		$('#menu-mensajes_pedido').load(base_url+'pedidos/sidebar_mensajes/'+order_id, function(){
			classie.toggle( document.getElementById('menu-mensajes_pedido'), 'cbp-spmenu-open' );
		});

	});

	$( document ).on( "click", ".a-close_mensajes_pedido", function() {
		$('#menu-mensajes_pedido').html('');
		classie.toggle( document.getElementById('menu-mensajes_pedido'), 'cbp-spmenu-open' );
	});


	//COMM STATUS
	var audiotypes={
        "mp3": "audio/mpeg",
        "mp4": "audio/mp4",
        "ogg": "audio/ogg",
        "wav": "audio/wav"
    }

    function ss_soundbits(sound){
        var audio_element = document.createElement('audio')
        if (audio_element.canPlayType){
            for (var i=0; i<arguments.length; i++){
                var source_element = document.createElement('source')
                source_element.setAttribute('src', arguments[i])
                if (arguments[i].match(/\.(\w+)$/i))
                    source_element.setAttribute('type', audiotypes[RegExp.$1])
                audio_element.appendChild(source_element)
            }
            audio_element.load()
            audio_element.playclip=function(){
                audio_element.pause()
                audio_element.currentTime=0
                audio_element.play()
            }
            return audio_element
        }
    }

    var ding  = ss_soundbits('../data/ding.mp3');

    //id="badge_mensajes_no_leidos"
    //id="badge_pedidos_no_procesados"

    function checkCommunicationStatus(initial){
    	var url = base_url+'dashboard/ajax_communication_status';

    	if(!initial){
    		var current_unread_messages = $('#badge_mensajes_no_leidos').html();
    		var current_unprocessed_orders = $('#badge_pedidos_no_procesados').html();
    	}

    	//Send ajax request
		$.ajax({
			url: url,
			type: "GET",
			// callback handler that will be called on success
			success: function(data){
				//Parseamos datos
				result = jQuery.parseJSON(data);

				//Mensajes no leidos.
				if(result.mensajes_no_leidos>0){
					$('#badge_mensajes_no_leidos').show()
					$('#badge_mensajes_no_leidos').html(result.mensajes_no_leidos);

					if(!initial && result.mensajes_no_leidos > current_unread_messages){
			    		ding.playclip();
			    	}
				}
				else{
					$('#badge_mensajes_no_leidos').hide();
				}

				//Pedidos no procesados
				if(result.pedidos_no_procesados>0){
					$('#badge_pedidos_no_procesados').show()
					$('#badge_pedidos_no_procesados').html(result.pedidos_no_procesados);

					if(!initial && result.pedidos_no_procesados > current_unprocessed_orders){
			    		ding.playclip();
			    	}
				}
				else{
					$('#badge_pedidos_no_procesados').hide();
				}

				//Details Mensajes No Leidos
				$('#div_mensajes_no_leidos').html('');
    			$('#div_mensajes_no_leidos').load(base_url+'dashboard/ajax_div_mensajes_no_leidos');

				//Details Pedidos No Procesados
				$('#ul_pedidos_no_procesados').html('');
    			$('#ul_pedidos_no_procesados').load(base_url+'dashboard/ajax_ul_pedidos_no_procesados');
			}
		});
    }

    //setInterval(function(){ checkCommunicationStatus(false); }, 10000);
    //checkCommunicationStatus(true);


});
