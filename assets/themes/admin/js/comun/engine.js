var tiempo_transicion = 300;
String.prototype.replaceAll = function(str1, str2, ignore)
{
   return this.replace(new RegExp(str1.replace(/([\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, function(c){return "\\" + c;}), "g"+(ignore?"i":"")), str2);
};
function mostrar_alerta(opcion,texto,tiempo,callback)
{
	opcion = typeof opcion !== 'undefined' ? opcion : "alerta_info";
	tiempo = typeof tiempo !== 'undefined' ? tiempo : 0;
	texto = typeof texto !== 'undefined' ? texto : "Cargando...";
  callback = typeof callback !== 'undefined' ? callback : null;
	//ejecutar = typeof ejecutar !== 'undefined' ? ejecutar : null;

	$('#alerta').removeClass();
	$('#alerta').addClass(opcion);
	if(opcion=="alerta_info")
	{
		texto = '<i style="text-shadow: 0px 0px 0ex;margin-top:5px;color:#fff;" class="text-primary fa fa-spin fa-fw pull-left fa-lg fa-refresh"></i> '+texto;
	}
	$('#alerta [name=contenido_alerta]').html(texto);
	if(tiempo==0) $('#alerta').show('slide',{direction:'up'},tiempo_transicion);
	else {
	$('#alerta').stop(true, true);
	$('#alerta').show('slide',{direction:'up'},tiempo_transicion).delay(tiempo).hide('slide',{direction:'up'},tiempo_transicion,function(){
    if(callback!=null)  callback();
  });
	}
}
function ocultar_alerta()
{
	 $('#alerta').hide('slide',{direction:'up'},tiempo_transicion);
}
function limpiar_formu(id)
{
$('#'+id+' input').each(function(){
	$(this).val('');
});
$('#'+id+' textarea').each(function(){
	$(this).val('');
});
}
var sort_by = function(field, reverse, primer){

   var key = primer ?
       function(x) {return primer(x[field])} :
       function(x) {return x[field]};

   reverse = [-1, 1][+!!reverse];

   return function (a, b) {
       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
     }

}

function selector_hora(hora,idinput)
{
	$('#'+idinput).val(hora);
	$('#selector_'+idinput).hide();
}

function preparar_datos_estadisticas_json(mi_json)
{


}

function limpiar_euros(cadena_limpiar)
{
	 cadena_limpiar = typeof cadena_limpiar !== 'undefined' ? cadena_limpiar : "";
	cadena_limpiar = cadena_limpiar.replace(/€/g,'0XE282AC');
	cadena_limpiar = cadena_limpiar.replace(/&/g,'0XE26');
	return cadena_limpiar;
}

function muestra_div(id)
{
	$('#'+id).show();
}

function oculta_div(id)
{
	$('#'+id).hide();
}

function toggle_div(id,name)
{
	$('[name='+name+']').hide();
	$('#'+id).toggle();
}

function EsEamil( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var es = true;
	if ( !expr.test(email) )
        es = false;
	return es;
}

function EsTelefonoMovil(tel) {
	var test = /^[67]\d{8}$/;
	var telReg = new RegExp(test);
	return telReg.test(tel);
}


Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function ordenar_json(mi_json,index,reverse,mode)
{
	var tmp = [];
	var cont=0;
	for(var i in mi_json)
	{
		tmp[cont] = mi_json[i];
		cont++;
	}
	tmp.sort(sort_by(index, reverse, mode));
	var tmp2 = {};
	for(var i in tmp)
	{
		tmp2[i] = tmp[i];
	}
	return tmp2;
}

function indexar_json_por(mi_json,index)
{
	var tmp = {};
	for(var i in mi_json)
	{
		var mi_index = mi_json[i][index];
		tmp[mi_index] = mi_json[i];
	}
	return tmp;
}
//Devuelve el index que lo contiene
function buscar_campo(mi_json,index,valor)
{
	for(var i in mi_json)
	{
		if(mi_json[i][index]==valor)
			return i;
	}
	return -1;
}
